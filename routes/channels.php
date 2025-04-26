<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return $user->chats()->where('id', $chatId)->exists();
});
Broadcast::channel('chat.{chatId}.typing', function ($user, $chatId) {
    return $user->chats()->where('id', $chatId)->exists();
});
Broadcast::channel('chat.{chatId}.message.{messageId}', function ($user, $chatId, $messageId) {
    return $user->chats()->where('id', $chatId)->exists();
});

Broadcast::channel('private-user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('user.{receiver_id}', function ($user, $receiver_id) {

    return (int) $user->id === (int) $receiver_id;
});

Broadcast::channel('chat.{chat_id}', function ($user, $chat_id) {

    return $user->chats()->where('id', $chat_id)->exists();
});


