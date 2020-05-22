<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('room');
    }

    public function send(int $id)
    {
        request()->validate(['text' => 'required|string|max:1500']);
        broadcast(new MessageSent(
            $id,
            request('password'),
            request('text'),
            auth()->user()
        ))->toOthers();
    }
}
