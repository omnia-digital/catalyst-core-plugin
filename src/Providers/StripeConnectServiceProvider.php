<?php

namespace OmniaDigital\CatalystCore\Providers;

use Illuminate\Support\ServiceProvider;
use OmniaDigital\CatalystCore\Support\StripeConnect\StripeConnect;

class StripeConnectServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (env('STRIPE_KEY')) {
            $this->app->singleton(StripeConnect::class, function () {
                return new StripeConnect(
                    secret: config('services.stripe.secret'),
                    refreshUrl: route('teams.stripe-connect.refresh')
                );
            });
        }
    }

    public function boot()
    {
    }
}
