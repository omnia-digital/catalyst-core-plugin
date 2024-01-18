<?php

namespace OmniaDigital\CatalystCore\Providers;

use Illuminate\Support\ServiceProvider;
use OmniaDigital\CatalystCore\Google\Client;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__.'/../../config/google.php' => config_path('google.php'),
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/google.php', 'google');

        $this->app->bind('OmniaDigital\CatalystCore\Google\Client', function ($app) {
            return new Client($app['config']['google']);
        });
    }
}
