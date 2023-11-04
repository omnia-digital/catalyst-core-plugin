<?php

namespace OmniaDigital\CatalystCore\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use OmniaDigital\CatalystCore\Models\ChargentSubscription;

class NewSubscriptionPayment extends BaseEvent
{
    use Dispatchable, SerializesModels;

    /**
     * @var ChargentSubscription
     */
    public $subscription;

    /**
     * Create a new event instance.
     */
    public function __construct(ChargentSubscription $subscription)
    {
        $this->subscription = $subscription;
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
