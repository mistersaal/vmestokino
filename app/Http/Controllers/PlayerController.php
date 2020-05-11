<?php

namespace App\Http\Controllers;

use App\Events\PlayerBuffering;
use App\Events\PlayerStart;
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
        broadcast(new PlayerStart($id, request('password'), request('currentTime')))->toOthers();
    }

    public function buffering(int $id)
    {
        broadcast(new PlayerBuffering($id, request('password'), request('currentTime')))->toOthers();
    }

    public function stop(int $id)
    {
        broadcast(new PlayerStop($id, request('password')))->toOthers();
    }
}
