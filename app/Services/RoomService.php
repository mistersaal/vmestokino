<?php


namespace App\Services;


use App\Events\RoomDeleted;
use App\Events\RoomUpdated;
use Illuminate\Support\Str;
use App\User;

class RoomService
{
    public function createRoom(User $user, array $data)
    {
        $data['password'] = Str::random(8);
        $user->room()->create($data);
    }

    public function updateUserRoom(User $user, array $data)
    {
        $user->room()->update($data);
        broadcast(new RoomUpdated($user->room->id, $user->room->password, $user->room));
    }

    public function deleteUserRoom(User $user)
    {
        $room = $user->room;
        $id = $room->id;
        $password = $room->password;
        $room->delete();
        broadcast(new RoomDeleted($id, $password));
    }
}
