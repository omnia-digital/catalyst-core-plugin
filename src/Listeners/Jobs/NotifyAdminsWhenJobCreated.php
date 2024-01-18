<?php

namespace OmniaDigital\CatalystCore\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use OmniaDigital\CatalystCore\Events\JobPositionWasCreated;
use OmniaDigital\CatalystCore\Notifications\JobPositionWasCreatedNotification;
use OmniaDigital\CatalystCore\Support\Notification\Notification;

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
