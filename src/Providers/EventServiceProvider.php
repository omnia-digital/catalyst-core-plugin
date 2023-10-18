<?php

namespace OmniaDigital\CatalystSocialPlugin\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Billing\Events\NewSubscriptionPayment;
use OmniaDigital\CatalystSocialPlugin\Listeners\TrackContributionToUserScore;
use OmniaDigital\CatalystSocialPlugin\Models\Post;
use OmniaDigital\CatalystSocialPlugin\Models\Profile;
use OmniaDigital\CatalystSocialPlugin\Observers\PostObserver;
use OmniaDigital\CatalystSocialPlugin\Observers\ProfileObserver;

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
