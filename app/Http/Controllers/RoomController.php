<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
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

    private function getValidDataForCreating()
    {
        return request()->validate([
            'title' => 'required|string|max:100',
            'everyone_control' => 'required|boolean',
            'url' => 'required|string|max:1000',
            'type' => [
                'required',
                Rule::in((new Room())->types)
            ]
        ]);
    }
}
