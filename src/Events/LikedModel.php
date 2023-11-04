<?php

namespace OmniaDigital\CatalystCore\Events;

use OmniaDigital\CatalystCore\Contracts\Events\ContributesToUserScore;
use OmniaDigital\CatalystCore\Models\User;
use Illuminate\Queue\SerializesModels;
use OmniaDigital\CatalystCore\Models\Post;

class LikedModel extends BaseEvent implements ContributesToUserScore
{
    use SerializesModels;

    /**
     * The user instance.
     *
     * @param User|Authenticatable
     */
    public $user;

    /**
     * The likable instance.
     *
     * @param mixed
     */
    public $model;

    /**
     * Match model class to contribution type
     *
     * @param array
     */
    public $modelClassEvents = [
        Post::class => LikedUserPost::class,
    ];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $model)
    {
        $this->user = $user;
        $this->model = $model;
    }

    public function trackContributionToUserScore()
    {
        $this->modelClassEvents[$this->model::class]::dispatch($this->user, $this->model);
    }
}
