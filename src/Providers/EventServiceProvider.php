<?php

namespace OmniaDigital\CatalystCore\Providers;

use App\Contracts\Events\ContributesToUserScore;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use OmniaDigital\CatalystCore\Listeners\TrackContributionToUserScore;
use OmniaDigital\CatalystCore\Models\Membership;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;
use OmniaDigital\CatalystCore\Observers\MembershipObserver;
use OmniaDigital\CatalystCore\Observers\PostObserver;
use OmniaDigital\CatalystCore\Observers\ProfileObserver;
use OmniaDigital\CatalystCore\Observers\TeamObserver;
use OmniaDigital\CatalystCore\Observers\UserObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        Team::class => [TeamObserver::class],
        User::class => [UserObserver::class],
        Membership::class => [MembershipObserver::class],
        Post::class => PostObserver::class,
        Profile::class => ProfileObserver::class,
    ];
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
//        NewSubscriptionPayment::class => [
//        ],
        ContributesToUserScore::class => [TrackContributionToUserScore::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
