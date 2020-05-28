<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\SendMessageRequest;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('room');
    }

    public function send(SendMessageRequest $request, int $id)
    {
        broadcast(new MessageSent(
            $id,
            $request->password,
            $request->text,
            auth()->user()
        ))->toOthers();
    }
}
