<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(int $id = null)
    {
        if (!$id) {
            $room = auth()->user()->room;
            if (!$room) {
                return response(['message' => 'Комната еще не создана'], 404);
            }
        } else {
            $room = Room::findOrFail($id);
            if ($room->password !== request('password')) {
                return response(['message' => 'Неверный пароль'], 403);
            }
        }
        $room->currentUserCanControl = auth()->user()->hasAccessToControlPlayer($room);
        $room->isAdmin = auth()->user()->isAdminInRoom($room);
        return $room;
    }

    public function create()
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user->room()->exists()) {
            return response(['message' => 'Комната уже существует'], 409);
        }
        $data = $this->getValidDataForCreating();
        $data['password'] = Str::random(8);

        $user->room()->create($data);
        return response(['message' => 'Комната создана'], 200);
    }

    public function delete()
    {
        /** @var User $user */
        $user = auth()->user();
        $room = $user->room;
        if (!$room) {
            return response(['message' => 'Комнаты не существует'], 404);
        }
        $room->delete();
        return response(['message' => 'Комната удалена'], 200);
    }

    private function getValidDataForCreating()
    {
        $room = new Room();
        return request()->validate([
            'everyone_control' => 'required|boolean',
            'type' => [
                'required',
                Rule::in($room->types)
            ],
            'url' => [
                'required',
                'string',
                'max:1000',
                'regex:' . ($room->validUrls[request('type')] ?? '/^\s*$/')
            ]
        ]);
    }
}
