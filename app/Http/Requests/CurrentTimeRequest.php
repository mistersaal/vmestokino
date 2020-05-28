<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrentTimeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'currentTime' => 'required|numeric|min:0'
        ];
    }
}
