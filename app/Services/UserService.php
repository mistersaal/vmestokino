<?php


namespace App\Services;


use App\User;

class UserService
{
    public $vkUsersData;

    public function __construct(VkUsersData $vkUsersData)
    {
        $this->vkUsersData = $vkUsersData;
    }

    public function updateUser(User $user): User
    {
        $this->vkUsersData->updateUserData($user);
        $user->save();
        return $user;
    }

    public function createNewUser(): User
    {
        $user = $this->vkUsersData->getNewUser();
        $user->save();
        return $user;
    }
}
