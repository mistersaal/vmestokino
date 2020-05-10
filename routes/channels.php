<?php

use App\Room;
use App\User;
use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('room.player.{room}.{password}', function (User $user, Room $room, $password) {
    if ($room->password === $password) {
        return $user;
    }
    return false;
});
