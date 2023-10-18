<?php

namespace OmniaDigital\CatalystCore\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Billing\Events\NewSubscriptionPayment;
use OmniaDigital\CatalystCore\Listeners\TrackContributionToUserScore;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Observers\PostObserver;
use OmniaDigital\CatalystCore\Observers\ProfileObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewSubscriptionPayment::class => [
        ],
        ContributesToUserScore::class => [TrackContributionToUserScore::class],
    ];

    protected $observers = [
        Post::class => PostObserver::class,
        Profile::class => ProfileObserver::class,
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
