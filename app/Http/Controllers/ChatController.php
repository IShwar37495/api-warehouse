<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\MessageStatusUpdated;
use App\Helpers\ApiResponse ;
use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ChatController extends Controller
{





      public function getChats()
    {
        $userId = Auth::id();

        $chats = Chat::whereHas('users', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['users' => function($query) use ($userId) {
                $query->where('user_id', '!=', $userId);
            }])
            ->withCount(['messages as unread_count' => function($query) use ($userId) {
                $query->whereHas('messageStatuses', function($statusQuery) use ($userId) {
                    $statusQuery->where('user_id', $userId)
                               ->where('status', 'sent');
                });
            }])
            ->get();

        // Get latest message for each chat
        foreach ($chats as $chat) {
            $chat->latest_message = Message::where('chat_id', $chat->id)
                ->with('messageStatuses')
                ->latest()
                ->first();

            // Add other user information
            $chat->other_user = $chat->users->first();
        }

        return ApiResponse::success(ChatResource::collection($chats));
    }

    /**
     * Get messages for a specific chat
     */
    public function getMessages($chatId)
    {
        // Check if user is part of this chat
        $userId = Auth::id();
        $isUserInChat = Chat::where('id', $chatId)
            ->whereHas('users', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->exists();

        if (!$isUserInChat) {
            return ApiResponse::error('Unauthorized access', 403);
        }

        // Get messages with pagination
        $messages = Message::where('chat_id', $chatId)
            ->with(['messageStatuses', 'sender'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return ApiResponse::success(MessageResource::collection($messages));
    }

    /**
     * Search for users
     */
    public function searchUsers(Request $request)
    {
        $searchTerm = $request->query('searchTerm', '');

        $users = User::where('id', '!=', Auth::id())
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            })
            ->paginate(30);

        return ApiResponse::success($users);
    }

    /**
     * Start or retrieve a chat with a user
     */
    public function startChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $senderId = Auth::id();
        $receiverId = $request->user_id;

        // Check if private chat already exists
        $chat = Chat::where('type', 'private')
            ->whereHas('users', fn($q) => $q->where('user_id', $senderId))
            ->whereHas('users', fn($q) => $q->where('user_id', $receiverId))
            ->first();

        // If no chat, create one
        if (!$chat) {
            $chat = Chat::create([
                'type' => 'private',
            ]);

            $chat->users()->attach([$senderId, $receiverId]);
        }

        return response()->json([
            'success' => true,
            'chat_id' => $chat->id
        ]);
    }

    /**
     * Send a message (text, image, or file)
     */
    public function send(Request $request)
    {
        // Validate the request
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'receiver_id' => 'required|exists:users,id',
            'type' => 'required|in:text,image,file',
        ]);

        // Additional validation based on message type
        if ($request->type === 'text') {
            $request->validate(['message' => 'required|string']);
        } else {
            $request->validate(['file' => 'required|file|max:10240']); // 10MB max
        }

        $senderId = Auth::id();
        $chatId = $request->chat_id;
        $receiverId = $request->receiver_id;

        // Check if user is part of this chat
        $isUserInChat = Chat::where('id', $chatId)
            ->whereHas('users', function($query) use ($senderId) {
                $query->where('user_id', $senderId);
            })
            ->exists();

        if (!$isUserInChat) {
            return ApiResponse::error('Unauthorized access', 403);
        }

        DB::beginTransaction();
        try {
            // Create message based on type
            $messageData = [
                'chat_id' => $chatId,
                'sender_id' => $senderId,
                'type' => $request->type,
            ];

            if ($request->type === 'text') {
                $messageData['message'] = $request->message;
            } else {
                // Handle file upload to Cloudinary
                $file = $request->file('file');
                $uploadResult = Cloudinary::upload($file->getRealPath(), [
                    'folder' => 'chat_files',
                    'resource_type' => $request->type === 'image' ? 'image' : 'raw'
                ]);

                $messageData['message'] = $file->getClientOriginalName();
                $messageData['file_url'] = $uploadResult->getSecurePath();
                $messageData['file_name'] = $file->getClientOriginalName();
                $messageData['file_size'] = $file->getSize();
                $messageData['file_type'] = $file->getMimeType();
                $messageData['cloudinary_id'] = $uploadResult->getPublicId();
            }

            $message = Message::create($messageData);

            // Create message status
            MessageStatus::create([
                'message_id' => $message->id,
                'user_id' => $receiverId,
                'status' => 'sent',
            ]);

            // Load relationships for response
            $message->load('messageStatuses', 'sender');

            DB::commit();

            // Broadcast the message
            broadcast(new MessageSent($message, $chatId, $receiverId))->toOthers();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to send message: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mark messages as seen
     */
    public function markAsSeen($chatId)
    {
        $userId = Auth::id();

        // Check if user is part of this chat
        $isUserInChat = Chat::where('id', $chatId)
            ->whereHas('users', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->exists();

        if (!$isUserInChat) {
            return ApiResponse::error('Unauthorized access', 403);
        }

        // Find messages that are not sent by the current user and update their status
        $messages = Message::where('chat_id', $chatId)
            ->where('sender_id', '!=', $userId)
            ->with('messageStatuses')
            ->get();

        foreach ($messages as $message) {
            $status = $message->messageStatuses()
                ->where('user_id', $userId)
                ->first();

            if ($status && $status->status !== 'seen') {
                $status->status = 'seen';
                $status->save();

                // Broadcast status update
                broadcast(new MessageStatusUpdated($message->id, $message->sender_id, 'seen'))->toOthers();
            }
        }

        return ApiResponse::success(true);
    }

    /**
     * Create a group chat
     */
    public function createGroupChat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $senderId = Auth::id();

        // Ensure current user is included
        $userIds = array_unique(array_merge($request->user_ids, [$senderId]));

        DB::beginTransaction();
        try {
            // Create the group chat
            $chat = Chat::create([
                'type' => 'group',
                'name' => $request->name
            ]);

            // Attach all users
            $chat->users()->attach($userIds, ['joined_at' => now()]);

            DB::commit();

            return ApiResponse::success(new ChatResource($chat));
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to create group: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a message (mark as deleted)
     */
    public function deleteMessage($messageId)
    {
        $userId = Auth::id();

        $message = Message::findOrFail($messageId);

        // Check if user is the sender of this message
        if ($message->sender_id !== $userId) {
            return ApiResponse::error('Unauthorized access', 403);
        }

        // Soft delete the message
        $message->deleted_at = now();
        $message->save();

        return ApiResponse::success(true);
    }

    /**
     * Get chat information including participants
     */
    public function getChatInfo($chatId)
    {
        $userId = Auth::id();

        // Check if user is part of this chat
        $chat = Chat::where('id', $chatId)
            ->whereHas('users', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['users'])
            ->first();

        if (!$chat) {
            return ApiResponse::error('Chat not found or unauthorized access', 404);
        }

        return ApiResponse::success(new ChatResource($chat));
    }

}
