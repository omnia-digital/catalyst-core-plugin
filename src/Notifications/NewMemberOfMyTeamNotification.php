<?php

namespace OmniaDigital\CatalystCore\Notifications;

use OmniaDigital\CatalystCore\Notifications\BaseNotification;
use App\Support\Notification\NotificationCenter;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;

class NewMemberOfMyTeamNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private User $newMember
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->id === $this->newMember->id) {
            return [];
        }

        return static::getChannels();
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
            ->icon('heroicon-o-user')
            ->success(Translate::get($this->newMember->name . ' has been added to the team, ' . $this->team->name))
            ->image($this->newMember->profile_photo_url)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
