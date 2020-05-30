<?php


namespace App\Services;


use App\User;
use Illuminate\Contracts\Auth\Guard;
use VK\Client\Enums\VKLanguage;
use VK\Client\VKApiClient;

class VkUsersData
{
    private $vkClient;
    private $vkGuard;
    private $token;

    public function __construct(Guard $vkGuard, string $token)
    {
        $this->vkClient = new VKApiClient('5.101', VKLanguage::RUSSIAN);
        $this->vkGuard = $vkGuard;
        $this->token = $token;
    }

    public function getUserData($vkId)
    {
        $data = $this->getUserDataFromApi($vkId);
        return [
            'vkid' => $vkId,
            'img' => $data['photo_50'],
            'name' => $data['first_name'] . ' ' . $data['last_name']
        ];
    }

    private function getUserDataFromApi($vkId)
    {
        $data = $this->vkClient->users()->get($this->token, [
            'user_ids' => $vkId,
            'fields' => 'first_name,last_name,photo_50'
        ]);
        return $data[0];
    }
}
