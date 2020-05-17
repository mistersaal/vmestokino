<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Room
 * @package App
 * @property int id
 * @property string password
 * @property User user
 * @property bool everyone_control
 * @property string url
 * @property string type
 */
class Room extends Model
{
    public $types = ['youtube'];
    public $validUrls = [
        'youtube' => '~^(https://)?(((www|m)\\.)?youtube\\.com/watch\\?v=|youtu\\.be/).+~'
    ];
    protected $fillable = [
        'password',
        'everyone_control',
        'url',
        'type'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
