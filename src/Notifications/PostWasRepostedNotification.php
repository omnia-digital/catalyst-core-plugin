<?php

namespace OmniaDigital\CatalystCore\Notifications;

use App\Models\User;
use OmniaDigital\CatalystCore\Notifications\BaseNotification;
use OmniaDigital\CatalystCore\Support\Notification\NotificationCenter;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Enums\PostType;
use OmniaDigital\CatalystCore\Models\Post;

class PostWasRepostedNotification extends BaseNotification
{
    public function __construct(
        private Post $post,
        private User $actionable
    ) {
    }

    public function via($notifiable): array
    {
        if ($notifiable->id === $this->post->user_id) {
            return [];
        }

        return static::getChannels();
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting($this->getTitle())
            ->line($this->getMessage())
            ->action('View Notifications', $this->getUrl());
    }

    public function getTitle()
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        return Translate::get($this->actionable->name . ' reposted your post');
    }

    public function getUrl()
    {
        return $this->post->type === PostType::ARTICLE->value
            ? route('resources.show', $this->post)
            : route('catalyst-social.posts.show', $this->post) ?? route('notifications');
    }

    public function toArray($notifiable): array
    {
        return NotificationCenter::make()
            ->icon('fa-light fa-arrows-rotate"')
            ->success($this->getMessage())
            ->subtitle($this->getSubTitle())
            ->image($this->getImage())
            ->actionLink($this->getUrl())
            ->actionText('View')
            ->toArray();
    }

    public function getSubTitle()
    {
        return $this->post->type === PostType::ARTICLE->value
            ? Str::of($this->post->body)->stripTags()->limit(155)
            : Str::of($this->post->body)->stripTags();
    }

    public function getImage()
    {
        return $this->actionable->profile_photo_url;
    }
}
