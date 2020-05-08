<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Room
 * @package App
 * @property int id
 * @property User user
 * @property string title
 * @property bool everyone_control
 * @property string url
 * @property string type
 */
class Room extends Model
{
    protected $types = ['youtube'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
