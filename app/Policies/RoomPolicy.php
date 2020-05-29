<?php

namespace App\Policies;

use App\Room;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RoomPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Room $room, string $password)
    {
        return $room->password === $password
            ? Response::allow()
            : Response::deny('Неверный пароль');
    }

    public function create(User $user)
    {
        return $user->room()->doesntExist()
            ? Response::allow()
            : Response::deny('Комната уже существует');
    }

    public function update(User $user)
    {
        return $this->checkUserRoomExists($user);
    }

    public function delete(User $user)
    {
        return $this->checkUserRoomExists($user);
    }

    private function checkUserRoomExists(User $user)
    {
        return $user->room()->exists()
            ? Response::allow()
            : Response::deny('Комната не существует');
    }
}
