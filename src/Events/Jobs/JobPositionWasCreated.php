<?php

namespace OmniaDigital\CatalystCore\Events\Jobs;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;

class JobPositionWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public JobPosition $job;

    /**
     * Create a new event instance.
     */
    public function __construct(JobPosition $job)
    {
        $this->job = $job;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
