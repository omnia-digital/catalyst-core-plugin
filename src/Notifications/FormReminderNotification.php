<?php

namespace OmniaDigital\CatalystCore\Notifications;

use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Models\FormNotification;
use OmniaDigital\CatalystCore\Models\Team;

class FormReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private FormNotification $formNotification
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
        if ($notifiable->hasTeamRole($this->team, $this->formNotification->role->name)) {
            return ['broadcast', 'database', 'mail'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reminder: ' . Translate::get($this->formNotification->name))
            ->greeting(Translate::get($this->formNotification->name))
            ->line(Translate::get($this->formNotification->message))
            ->line('Team: ' . $this->team->name)
            ->line('Form: ' . $this->formNotification->form->name)
            ->action('Go to Team Page', route('catalyst-social.teams.show', $this->team))
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = route('catalyst-social.teams.show', $this->team);

        return NotificationCenter::make()
            ->icon('heroicon-o-clock')
            ->info(Translate::get($this->formNotification->name))
            ->subtitle(Translate::get($this->formNotification->message))
            ->image($this->team->profile_photo_url)
            ->actionLink($url)
            ->actionText('Go to Team Page')
            ->toArray();
    }
}
