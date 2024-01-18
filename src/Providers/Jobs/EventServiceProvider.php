<?php

namespace OmniaDigital\CatalystCore\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use OmniaDigital\CatalystCore\Events\JobPositionWasCreated;
use OmniaDigital\CatalystCore\Listeners\CreateStripeCustomer;
use OmniaDigital\CatalystCore\Listeners\NotifyAdminsWhenJobCreated;
use OmniaDigital\CatalystCore\Listeners\NotifyContractorsWhenJobCreated;
use OmniaDigital\CatalystCore\Listeners\TweetJob;
use OmniaDigital\CatalystCore\Listeners\UpdateGoogleJobsWhenJobCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateStripeCustomer::class,
        ],

        JobPositionWasCreated::class => [
            NotifyContractorsWhenJobCreated::class,
            NotifyAdminsWhenJobCreated::class,
            TweetJob::class,
            UpdateGoogleJobsWhenJobCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
