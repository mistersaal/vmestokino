<?php

namespace App\Http\Middleware;

use App\Room;
use Closure;

class RoomPlayer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $room = Room::findOrFail($request->route('id'));
        if (
            $room->password !== $request->get('password') ||
            !auth()->user()->hasAccessToControlPlayer($room)
        ) {
            return response(['message' => 'Доступ запрещен'], 403);
        }
        return $next($request);
    }
}
