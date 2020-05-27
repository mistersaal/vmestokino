<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Mistersaal\VkMiniAppsAuth\VkMiniAppsAuthenticatable;

/**
 * Class User
 * @package App
 * @property int id
 * @property string name
 * @property string vkid
 * @property string img
 * @property Room room
 */
class User extends Authenticatable implements VkMiniAppsAuthenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'vkid', 'img'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function room()
    {
        return $this->hasOne(Room::class);
    }

    public function hasAccessToControlPlayer(Room $room)
    {
        if ($room->everyone_control) {
            return true;
        } else {
            return $this->isAdminInRoom($room);
        }
    }

    public function isAdminInRoom(Room $room)
    {
        if ($room->user_id === $this->id) {
            return true;
        }
        return false;
    }

    public function getVkIdFieldName()
    {
        return 'vkid';
    }
}
