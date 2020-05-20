<?php

namespace App\Http\Controllers;

use App\Events\PlayerBuffering;
use App\Events\PlayerStart;
use App\Events\PlayerState;
use App\Events\PlayerStop;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('room.player');
    }

    public function start(int $id)
    {
        request()->validate([
            'currentTime' => 'required|numeric|min:0'
        ]);
        broadcast(new PlayerStart($id, request('password'), request('currentTime')))->toOthers();
    }

    public function buffering(int $id)
    {
        request()->validate([
            'currentTime' => 'required|numeric|min:0'
        ]);
        broadcast(new PlayerBuffering($id, request('password'), request('currentTime')))->toOthers();
    }

    public function stop(int $id)
    {
        broadcast(new PlayerStop($id, request('password')))->toOthers();
    }

    public function sync(int $id)
    {
        request()->validate([
            'isPlaying' => 'required|boolean',
            'currentTime' => 'required|numeric|min:0'
        ]);
        broadcast(new PlayerState($id, request('password'), request()->all()))->toOthers();
    }
}
