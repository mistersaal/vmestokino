<?php

namespace App\Http\Controllers;

use App\Events\PlayerBuffering;
use App\Events\PlayerStart;
use App\Events\PlayerState;
use App\Events\PlayerStop;
use App\Http\Requests\CurrentTimeRequest;
use App\Http\Requests\SyncTimeRequest;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('room.player');
    }

    public function start(CurrentTimeRequest $request, int $id)
    {
        broadcast(new PlayerStart($id, $request->password, $request->currentTime))->toOthers();
    }

    public function buffering(CurrentTimeRequest $request, int $id)
    {
        broadcast(new PlayerBuffering($id, $request->password, $request->currentTime))->toOthers();
    }

    public function stop(Request $request, int $id)
    {
        broadcast(new PlayerStop($id, $request->password))->toOthers();
    }

    public function sync(SyncTimeRequest $request, int $id)
    {
        broadcast(new PlayerState($id, $request->password, $request->validated()))->toOthers();
    }
}
