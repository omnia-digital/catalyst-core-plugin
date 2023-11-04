<?php

namespace OmniaDigital\CatalystCore\Events;

use OmniaDigital\CatalystCore\Contracts\Events\ContributesToUserScore;
use OmniaDigital\CatalystCore\Models\User;
use Illuminate\Queue\SerializesModels;
use OmniaDigital\CatalystCore\Models\UserScoreContribution;

class CreatedTeam extends BaseEvent implements ContributesToUserScore
{
    use SerializesModels;

    /**
     * The user instance.
     *
     * @param User|Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function trackContributionToUserScore()
    {
        $this->user->profile->score += UserScoreContribution::getPointsFor('Created Team');
        $this->user->profile->save();
    }
}
