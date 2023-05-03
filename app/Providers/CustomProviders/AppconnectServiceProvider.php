<?php

namespace App\Providers\CustomProviders;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class AppconnectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }

    public function extendSocialite()
    {
        Socialite::extend('appconnect', function ($app) {
            $config = $app['config']['services.appconnect'];

            return Socialite::buildProvider(AppconnectProvider::class, $config);
        });
    }
}
