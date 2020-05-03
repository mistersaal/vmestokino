<?php

namespace App\Providers;

use App\Services\VkAuth\VkGuard;
use App\Services\VkAuth\VkSign;
use App\Services\VkAuth\VkUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('vk', function ($app, array $config) {
            return new VkUserProvider();
        });

        Auth::extend('vkHeader', function ($app, $name, array $config) {
            return new VkGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request'),
                $app->make(VkSign::class)
            );
        });
    }
}
