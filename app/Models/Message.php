<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cloudinary;
use Cloudinary\Cloudinary as CloudinaryCloudinary;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary as FacadesCloudinary;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'chat_id',
        'message',
        'type',
        'file_url',
        'file_name',
        'file_size',
        'file_type',
        'cloudinary_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'file_size' => 'integer'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->select('id', 'name', 'email');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function statuses()
    {
        return $this->hasMany(MessageStatus::class);
    }

    public function messageStatuses()
    {
        return $this->hasMany(MessageStatus::class);
    }

    // Add method to delete file from Cloudinary when message is deleted
    protected static function booted()
    {
        static::deleting(function ($message) {
            if ($message->cloudinary_id) {
                CloudinaryCloudinary::destroy($message->cloudinary_id);
            }
        });
    }
}
