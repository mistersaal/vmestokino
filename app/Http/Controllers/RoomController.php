<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\RoomDataRequest;
use App\Room;
use App\Services\RoomService;

class RoomController extends Controller
{
    private $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index()
    {
        $user = auth()->user();
        $room = $user->room()->first() ?? abort(404, 'Комнаты не существует');
        $this->roomService->setAdditionalFieldsToRoom($room, $user);

        return $room;
    }

    public function get(Room $room, PasswordRequest $request)
    {
        $this->authorize('view', [$room, $request->password]);

        $this->roomService->setAdditionalFieldsToRoom($room, auth()->user());

        return $room;
    }

    public function check(Room $room, PasswordRequest $request)
    {
        $this->authorize('view', [$room, $request->password]);

        return response(['message' => 'Доступ разрешен'], 200);
    }

    public function create(RoomDataRequest $request)
    {
        $this->authorize('create', Room::class);

        $this->roomService->createRoom(auth()->user(), $request->validated());

        return response(['message' => 'Комната создана'], 200);
    }

    public function update(RoomDataRequest $request)
    {
        $this->authorize('update', Room::class);

        $this->roomService->updateUserRoom(auth()->user(), $request->validated());

        return response(['message' => 'Комната отредактирована'], 200);
    }

    public function delete()
    {
        $this->authorize('delete', Room::class);

        $this->roomService->deleteUserRoom(auth()->user());

        return response(['message' => 'Комната удалена'], 200);
    }
}
