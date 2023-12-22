<?php

namespace OmniaDigital\CatalystCore\Events;

use OmniaDigital\CatalystCore\Models\Team;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Subscription;

class TeamMemberSubscriptionCreatedEvent extends BaseEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public Subscription $subscription,
        public User $billable,
        public Team $team
    ) {
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
