<?php


namespace App\Services\VkAuth;


use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class VkUserProvider implements UserProvider
{

    public function retrieveById($identifier)
    {
        return User::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        //
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        //
    }

    public function retrieveByCredentials(array $credentials)
    {
        return User::firstWhere('vkid', $credentials['vk_user_id']);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $user->vkid === $credentials['vk_user_id'];
    }
}
