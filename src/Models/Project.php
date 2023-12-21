<?php

namespace OmniaDigital\CatalystCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Traits\Awardable;
use OmniaDigital\CatalystCore\Traits\HasAssociations;
use OmniaDigital\CatalystCore\Traits\Likable;
use OmniaDigital\CatalystCore\Traits\Postable;
use OmniaDigital\CatalystLocation\Traits\Location\HasLocation;
use Overtrue\LaravelFollow\Traits\Followable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

/**
 * Teams are just Teams
 */
class Project extends Model implements HasMedia, Searchable
{
//    use HasFactory;
    use Awardable;
    use HasLocation;
    use Followable;
    use HasAssociations;
    use HasProfilePhoto;
    use HasSlug;
    use HasTags;
    use InteractsWithMedia;
    use Likable;
    use Notifiable;
    use Postable;

//    protected static function newFactory()
//    {
//        return app(ProjectFactory::class);
//    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'handle',
        'start_date',
        'end_date',
        'summary',
        'content',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
        'location_short',
        'start_date_string',
        'end_date_string',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
//        'created' => TeamCreated::class,
//        'updated' => TeamUpdated::class,
//        'deleted' => TeamDeleted::class,
    ];


    public function getSearchResult(): SearchResult
    {
        $url = route('catalyst-social.projects.show', $this);

        return (new SearchResult($this, $this->name, $url))->setType(Translate::get('Projects'));
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('handle');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
