<?php

namespace OmniaDigital\CatalystCore\Models;

use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use OmniaDigital\CatalystCore\Database\Factories\TeamFactory;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Jetstream\Team as JetstreamTeam;
use OmniaDigital\CatalystCore\Traits\CatalystTeamTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Teams are just Teams
 */
class Team extends JetstreamTeam implements HasMedia, Searchable
{
    use CatalystTeamTraits;
    use HasFactory;

    protected static function newFactory()
    {
        return app(TeamFactory::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'handle',
        'start_date',
        'summary',
        'content',
        'stripe_connect_id',
        'stripe_connect_onboarding_completed',
    ];

    protected $casts = [
        'stripe_connect_onboarding_completed' => 'boolean',
        'start_date' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
        'location_short',
        'start_date_string',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];


    public function getSearchResult(): SearchResult
    {
        $url = route('catalyst-social.teams.show', $this);

        return (new SearchResult($this, $this->name, $url))->setType(Trans::get('Teams'));
    }

}
