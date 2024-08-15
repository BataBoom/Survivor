<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Pool;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chat', function (User $user) {
   Log::info('Authorizing user for CHAT', ['user_id' => $user->id]);
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('public-chat', function () {
    return true;
});

// Allows to listen to the chatroom messages.
Broadcast::channel('game.chatroom.{pool}', function (User $user, Pool $pool) {
    Log::info('Authorizing user for CHAT', ['user_id' => $user->id]);
    return $pool->contenders->contains('user_id', $user->id);
});

// Presence channel to support features like `online users` and `typing`.
Broadcast::channel('game.chatroom.{pool}.presence', function (User $user, Pool $pool) {
    return $pool->contenders->contains('user_id', $user->id);
});
