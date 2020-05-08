<?php


namespace App\Services\VkAuth;


use App\User;
use Illuminate\Contracts\Auth\Guard;
use VK\Client\VKApiClient;

class VkUsersData
{
    private $vkClient;
    private $vkGuard;
    private $token;

    public function __construct(VKApiClient $vkClient, Guard $vkGuard)
    {
        $this->vkClient = $vkClient;
        $this->vkGuard = $vkGuard;
        $this->token = config('vk.app.token');
    }

    public function getNewUser()
    {
        $vkId = $this->vkGuard->getCredentials()['vk_user_id'];
        $data = $this->getUserData($vkId);
        return new User([
            'vkid' => $vkId,
            'img' => $data['photo_50'],
            'name' => $data['first_name'] . ' ' . $data['last_name']
        ]);
    }

    public function updateUserData(User $user)
    {
        $data = $this->getUserData($user->vkid);
        $user->img = $data['photo_50'];
        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        return $user;
    }

    private function getUserData($vkId)
    {
        $data = $this->vkClient->users()->get($this->token, [
            'user_ids' => $vkId,
            'fields' => 'first_name,last_name,photo_50'
        ]);
        return $data[0];
    }
}
