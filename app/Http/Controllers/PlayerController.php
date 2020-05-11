<?php

namespace App\Http\Controllers;

use App\Events\PlayerStart;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('room.player');
    }

    public function start(int $id)
    {
        broadcast(new PlayerStart($id, request('password')))->toOthers();
    }
}
