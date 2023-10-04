<?php

namespace OmniaDigital\CatalystCore\Events;

use App\Contracts\Events\ContributesToUserScore;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Queue\SerializesModels;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Models\User;
use OmniaDigital\CatalystCore\Models\UserScoreContribution;

class LikedUserPost extends BaseEvent implements ContributesToUserScore
{
    use SerializesModels;

    /**
     * The user instance.
     *
     * @param User|Authenticatable
     */
    public $user;

    /**
     * The post instance.
     *
     * @param Post
     */
    public $post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function trackContributionToUserScore()
    {
        $this->user->profile->score += UserScoreContribution::getPointsFor('Liked User Post');
        $this->user->profile->save();

        $this->post->user->profile->score += UserScoreContribution::getPointsFor('Post Was Liked');
        $this->post->user->profile->save();
    }
}
