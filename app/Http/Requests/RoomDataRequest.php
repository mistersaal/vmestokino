<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Room;

class RoomDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'everyone_control' => 'required|boolean',
            'type' => [
                'required',
                Rule::in(Room::$types)
            ],
            'url' => [
                'required',
                'string',
                'max:1000',
                'regex:' . (Room::$validUrls[$this->type] ?? '/^\s*$/')
            ]
        ];
    }
}
