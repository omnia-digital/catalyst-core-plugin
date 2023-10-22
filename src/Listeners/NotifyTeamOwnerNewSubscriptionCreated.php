<?php

namespace OmniaDigital\CatalystCore\Listeners;

use OmniaDigital\CatalystCore\Notifications\TeamMemberSubscriptionCreatedNotification;
use OmniaDigital\CatalystCore\Events\TeamMemberSubscriptionCreatedEvent;

class NotifyTeamOwnerNewSubscriptionCreated
{
    /**
     * Handle the event.
     *
     * @param  TeamMemberSubscriptionCreatedEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $event->team->owner->notify(
            new TeamMemberSubscriptionCreatedNotification
        );
    }
}
