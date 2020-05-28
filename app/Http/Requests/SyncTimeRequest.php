<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncTimeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'isPlaying' => 'required|boolean',
            'currentTime' => 'required|numeric|min:0'
        ];
    }
}
