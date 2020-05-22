<?php

namespace App\Http\Middleware;

use Closure;

class Room
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
        $room = \App\Room::findOrFail($request->route('id'));

        if ($room->password !== $request->get('password')) {
            return response(['message' => 'Доступ запрещен'], 403);
        }

        return $next($request);
    }
}
