<?php


namespace App\Http\Middleware;


use Illuminate\Contracts\Auth\Factory as Auth;

class VkAuthenticate extends Authenticate
{
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
        auth()->validate();
    }
}
