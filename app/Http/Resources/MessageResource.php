<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MessageResource extends JsonResource
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
            'chat_id' => $this->chat_id,
            'sender_id' => $this->sender_id,
            'message' => $this->message,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Add sender info if loaded
        if ($this->relationLoaded('sender')) {
            $data['sender'] = [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'email' => $this->sender->email,
            ];
        }

        // Add file info for non-text messages
        if ($this->type !== 'text') {
            $data['file_name'] = $this->file_name;
            $data['file_size'] = $this->file_size;
            $data['file_type'] = $this->file_type;
            $data['file_url'] = $this->file_url;

            // Add optimized image URL for images
            if ($this->type === 'image' && $this->file_url) {
                $data['thumbnail_url'] = str_replace('/upload/', '/upload/w_300,h_300,c_fill/', $this->file_url);
            }
        }

        // Add message status
        if ($this->relationLoaded('messageStatuses') && count($this->messageStatuses) > 0) {
            $data['status'] = $this->messageStatuses[0]->status;
        }

        return $data;
    }
}
