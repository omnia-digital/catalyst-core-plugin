<?php

namespace OmniaDigital\CatalystCore\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use OmniaDigital\CatalystCore\Database\Factories\PostFactory;
use OmniaDigital\CatalystCore\Enums\PostType;
use OmniaDigital\CatalystCore\Traits\Attachable;
use OmniaDigital\CatalystCore\Traits\Bookmarkable;
use OmniaDigital\CatalystCore\Traits\Likable;
use OmniaDigital\CatalystCore\Traits\Postable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia, Searchable
{
    use Attachable;
    use Bookmarkable;
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;
    use Likable;
    use Postable;

    protected $fillable = [
        'user_id',
        'team_id',
        'title',
        'type',
        'body',
        'url',
        'postable_id',
        'postable_type',
        'repost_original_id',
        'published_at',
        'image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public static function getTrending($type = 'post')
    {
        $trendingPosts = Post::withCount('likes')
            ->with('user')
            ->when($type, fn ($query) => $query->where('type', $type))
            ->whereNotNull('published_at')
            ->orderBy('likes_count', 'desc')
            ->orderBy('created_at', 'desc');

        return $trendingPosts;
    }

    protected static function booted()
    {
        // @NOTE - this is so we don't accidentally pull in comments when we are trying to just get regular posts
        static::addGlobalScope('parent', function (Builder $builder) {
            $builder->whereNull('postable_id');
        });
    }

    protected static function newFactory()
    {
        return PostFactory::new();
    }

    public function type(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? PostType::tryFrom($value) : null,
            set: fn ($value) => $value?->value
        );
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getPublishedAtAttribute($value)
    {
        if ($this->type === PostType::ARTICLE) {
            return is_null($value) ? null : $this->asDateTime($value);
        }

        return $this->created_at;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class)->withDefault([
            'name' => 'No Team',
        ]);
    }

    public function postable(): MorphTo
    {
        return $this->morphTo();
    }

    public function repostOriginal(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function isRepost(): bool
    {
        return ! is_null($this->repost_original_id);
    }

    public function attachMedia(array $mediaUrls): self
    {
        /** @var string $mediaUrl */
        foreach ($mediaUrls as $mediaUrl) {
            $this->addMediaFromUrl($mediaUrl)->toMediaCollection();
        }

        return $this;
    }

    public function getUrl(): string
    {
        if ($this->type === PostType::ARTICLE) {
            return route('resources.show', $this);
        }

        return route('social.posts.show', $this);
    }

    public function scopeOnlyResources($query)
    {
        return $query->where('type', PostType::ARTICLE);
    }

    public function scopeOnlyPosts($query)
    {
        return $query->whereNull('type');
    }

    public function isParent(): bool
    {
        return is_null($this->postable_id) && is_null($this->postable_type);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('social.posts.show', $this);

        return (new SearchResult($this, $this->title, $url))->setType($this->type?->value ?? $this->getTable());
    }
}
