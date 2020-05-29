<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\RoomDataRequest;
use App\Room;
use App\Services\RoomService;
use App\User;

class RoomController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $room = $user->room()->firstOrFail();
        $this->setAdditionalFieldsToRoom($room, $user);

        return $room;
    }

    public function get(Room $room, PasswordRequest $request)
    {
        $this->authorize('view', [$room, $request->password]);

        $this->setAdditionalFieldsToRoom($room, auth()->user());

        return $room;
    }

    private function setAdditionalFieldsToRoom(Room $room, User $user)
    {
        $room->currentUserCanControl = $user->hasAccessToControlPlayer($room);
        $room->isAdmin = $user->isAdminInRoom($room);
    }

    public function create(RoomDataRequest $request, RoomService $roomService)
    {
        $this->authorize('create', Room::class);

        $roomService->createRoom(auth()->user(), $request->validated());

        return response(['message' => 'Комната создана'], 200);
    }

    public function update(RoomDataRequest $request, RoomService $roomService)
    {
        $this->authorize('update', Room::class);

        $roomService->updateUserRoom(auth()->user(), $request->validated());

        return response(['message' => 'Комната отредактирована'], 200);
    }

    public function delete(RoomService $roomService)
    {
        $this->authorize('delete', Room::class);

        $roomService->deleteUserRoom(auth()->user());

        return response(['message' => 'Комната удалена'], 200);
    }
}
