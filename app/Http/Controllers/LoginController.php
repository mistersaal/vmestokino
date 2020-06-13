<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class LoginController extends Controller
{
    public function login(UserService $userService)
    {
        if (auth()->validate()) {
            $user = $userService->updateUser(auth()->user());
            return [
                'newUser' => false,
                'room' => $user->room,
                'user' => $user->withoutRelations(),
            ];
        } else {
            $user = $userService->createNewUser(auth()->getVkIdentifier());
            return [
                'newUser' => true,
                'room' => null,
                'user' => $user,
            ];
        }
    }
}
