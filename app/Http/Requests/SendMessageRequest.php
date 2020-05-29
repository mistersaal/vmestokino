<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function rules()
    {
        return ['text' => 'required|string|max:1500'];
    }
}
