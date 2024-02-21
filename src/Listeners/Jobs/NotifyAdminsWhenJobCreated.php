<?php

namespace OmniaDigital\CatalystCore\Listeners\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use OmniaDigital\CatalystCore\Events\Jobs\JobPositionWasCreated;
use OmniaDigital\CatalystCore\Notifications\Jobs\JobPositionWasCreatedNotification;
use OmniaDigital\CatalystCore\Support\Jobs\Notification\Notification;

class NotifyAdminsWhenJobCreated implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(JobPositionWasCreated $event)
    {
        Notification::make(new JobPositionWasCreatedNotification($event->job))->toAdmin();
    }
}
