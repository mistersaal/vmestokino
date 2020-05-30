<?php

namespace App\Providers;

use App\Services\VkUsersData;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VkUsersData::class, function ($app) {
            return new VkUsersData($app->make(Guard::class), config('vkminiapps.app.token'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
