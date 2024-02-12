<?php

namespace OmniaDigital\CatalystCore\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\ServiceProvider;
use OmniaDigital\CatalystCore\Events\Jobs\JobPositionWasCreated;
use OmniaDigital\CatalystCore\Listeners\CreateStripeCustomer;
use OmniaDigital\CatalystCore\Listeners\NotifyAdminsWhenJobCreated;
use OmniaDigital\CatalystCore\Listeners\NotifyContractorsWhenJobCreated;
use OmniaDigital\CatalystCore\Listeners\NotifyTeamOwnerNewSubscriptionCreated;
use OmniaDigital\CatalystCore\Events\TeamMemberSubscriptionCreatedEvent;
use OmniaDigital\CatalystCore\Listeners\TweetJob;
use OmniaDigital\CatalystCore\Listeners\UpdateGoogleJobsWhenJobCreated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TeamMemberSubscriptionCreatedEvent::class => [
            NotifyTeamOwnerNewSubscriptionCreated::class,
        ],
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
}
