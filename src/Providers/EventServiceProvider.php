<?php

namespace OmniaDigital\CatalystCore\Providers;

use Illuminate\Support\ServiceProvider;
use OmniaDigital\CatalystCore\Listeners\NotifyTeamOwnerNewSubscriptionCreated;
use OmniaDigital\CatalystCore\Events\TeamMemberSubscriptionCreatedEvent;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TeamMemberSubscriptionCreatedEvent::class => [
            NotifyTeamOwnerNewSubscriptionCreated::class,
        ],
    ];
}
