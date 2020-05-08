<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Room
 * @package App
 * @property int id
 * @property string password
 * @property User user
 * @property string title
 * @property bool everyone_control
 * @property string url
 * @property string type
 */
class Room extends Model
{
    public $types = ['youtube'];
    protected $fillable = [
        'password',
        'title',
        'everyone_control',
        'url',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}