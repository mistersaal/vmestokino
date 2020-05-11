<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App
 * @property int id
 * @property string name
 * @property string vkid
 * @property string img
 */
class User extends Authenticatable
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
            if ($room->user_id === $this->id) {
                return true;
            }
        }
        return false;
    }
}
