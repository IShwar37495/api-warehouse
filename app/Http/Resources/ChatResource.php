<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Add group name if it's a group chat
        if ($this->type === 'group' && isset($this->name)) {
            $data['name'] = $this->name;
        }

        // Add latest message if loaded
        if (isset($this->latest_message)) {
            $data['latest_message'] = new MessageResource($this->latest_message);
        }

        // Add unread count if loaded
        if (isset($this->unread_count)) {
            $data['unread_count'] = $this->unread_count;
        }

        // Add other user info if available (for private chats)
        if (isset($this->other_user)) {
            $data['other_user'] = [
                'id' => $this->other_user->id,
                'name' => $this->other_user->name,
                'email' => $this->other_user->email,
            ];
        }

        // Add all participants if users relation is loaded
        if ($this->relationLoaded('users')) {
            $data['participants'] = $this->users->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
            });
        }

        return $data;
    }
}
