<?php

namespace OmniaDigital\CatalystCore\Notifications;

use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;
use App\Notifications\BaseNotification;
use App\Support\Notification\NotificationCenter;
use OmniaDigital\CatalystCore\Facades\Translate;

class ApplicationAcceptedToTeamNotification extends BaseNotification
{
    public static string $label = 'Application Accepted';

    public static string $description = 'This is a notification when your application to a team has been accepted.';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private User $applicant
    ) {
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = $this->team->profile();

        return NotificationCenter::make()
            ->icon('heroicon-o-check')
            ->success(Translate::get('Your application to ' . $this->team->name . ' has been accepted'))
            ->image($this->team->profile_photo_url)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
