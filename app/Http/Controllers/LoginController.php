<?php

namespace App\Http\Controllers;

use App\Services\VkAuth\VkUsersData;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(VkUsersData $vkUsersData)
    {
        if (auth()->validate()) {
            /** @var User $user */
            $user = auth()->user();
            $vkUsersData->updateUserData($user);
            $user->save();
            return [
                'newUser' => false,
                'room' => $user->room,
                'user' => $user,
            ];
        } else {
            $user = $vkUsersData->getNewUser();
            $user->save();
            return [
                'newUser' => true,
                'room' => null,
                'user' => $user,
            ];
        }
    }
}
