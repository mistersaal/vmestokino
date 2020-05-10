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
            $roomExists = $user->room()->exists();
            $vkUsersData->updateUserData($user);
            $user->save();
            return [
                'newUser' => false,
                'hasRoom' => $roomExists
            ];
        } else {
            $user = $vkUsersData->getNewUser();
            $user->save();
            return [
                'newUser' => true,
                'hasRoom' => false
            ];
        }
    }
}
