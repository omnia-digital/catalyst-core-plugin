<?php

namespace OmniaDigital\CatalystCore\Livewire;

use Livewire\Component;
use OmniaDigital\CatalystCore\Notifications\ApplicationAcceptedToTeamNotification;
use OmniaDigital\CatalystCore\Notifications\NewApplicationToTeamNotification;
use OmniaDigital\CatalystCore\Notifications\NewCommentNotification;
use OmniaDigital\CatalystCore\Notifications\NewFollowerNotification;
use OmniaDigital\CatalystCore\Notifications\NewMemberOfMyTeamNotification;

class NotificationManager extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function getAllNotificationsProperty()
    {
        return [
            ApplicationAcceptedToTeamNotification::class,
            NewApplicationToTeamNotification::class,
            NewCommentNotification::class,
            NewFollowerNotification::class,
            NewMemberOfMyTeamNotification::class,
        ];
    }

    public function getChannelLabel($channel)
    {
        return match ($channel) {
            'mail' => 'Email',
            'database' => 'In-App',
            'broadcast' => 'Push',
            'sms' => 'SMS',
            default => 'Unknown',
        };
    }

    public function getSubscriptionsProperty()
    {
        return $this->user->notificationSubscriptions();
    }

    public function render()
    {
        return view('catalyst::livewire.notification-manager');
    }
}
