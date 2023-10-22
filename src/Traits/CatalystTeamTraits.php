<?php

namespace OmniaDigital\CatalystCore\Traits;

use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\HasProfilePhoto;
use OmniaDigital\CatalystCore\Traits\Tag\HasTeamTags;
use OmniaDigital\CatalystCore\Traits\Tag\HasTeamTypeTags;
use Overtrue\LaravelFollow\Traits\Followable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Tags\HasTags;
use Spatie\Sluggable\SlugOptions;
trait CatalystTeamTraits
{
    use Awardable;
    //    use HasLocation;
    use Followable;
    use HasAssociations;

    use HasProfilePhoto;
    use HasSlug;
    use HasTags, HasTeamTags {
        HasTeamTags::tags insteadof HasTags;
    }
    use HasTeamTypeTags;
    use InteractsWithMedia;
    use Likable;
    use Notifiable;
    use Postable;
    //    use Reviewable;

    const DEFAULT_TEAM_NAME = 'Default Org';

    public static function findByHandle($handle)
    {
        return Team::where('handle', $handle)
            ->first();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('handle');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'handle';
    }

    public function getThumbnailAttribute($value)
    {
        if (empty($value)) {
            return 'https://via.placeholder.com/200';
        }

        return $value;
    }

    public function attachMedia(array $mediaUrls): self
    {
        /** @var string $mediaUrl */
        foreach ($mediaUrls as $mediaUrl) {
            $this->addMediaFromUrl($mediaUrl)
                ->toMediaCollection();
        }

        return $this;
    }

    public function getDefaultRoleAttribute($value)
    {
        return config('platform.teams.default_member_role');
    }

    public function hasInfoIsFilled(): bool
    {
        return ! $this->hasDefaultTeamName() && ! empty($this->phone) && ! empty($this->city) && ! empty($this->state);
    }

    public function hasDefaultTeamName(): bool
    {
        return $this->name === $this->getDefaultTeamName();
    }

    public function getDefaultTeamName(): string
    {
        return $this->owner?->profile?->first_name . Trans::get("'s Team") ?? Trans::get('Default Team');
    }

    // Relations //
    public function teamNotifications(): HasMany
    {
        return $this->hasMany(TeamNotification::class);
    }

    public function postsWithinTeam()
    {
        return $this->hasMany(Post::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Post::class)
            ->ofType(PostType::ARTICLE)
            ->ofType(PostType::RESOURCE);
    }

    public function teamLink()
    {
        return route('catalyst-social.teams.show', $this->id);
    }

    public function visits(): Relation
    {
        return visits($this)->relation();
    }

    public function bannerImage()
    {
        return optional($this->getMedia('team_banner_images')
            ->first());
    }

    public function mainImage()
    {
        return optional($this->getMedia('team_main_images')
            ->first());
    }

    /**
     * Get the URL to the team's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profilePhoto()
            ->getFullUrl() ?? $this->defaultProfilePhotoUrl();
    }

    public function profilePhoto()
    {
        return optional($this->getMedia('team_profile_photos')
            ->first());
    }

    // Attributes //

    public function sampleImages()
    {
        return $this->getMedia('team_sample_images')
            ->count() ? $this->getMedia('team_sample_images') : (new NullMedia);
    }

    public function getStartDateStringAttribute()
    {
        return $this->start_date?->toFormattedDateString();
    }

    public function getReviewScoreAttribute()
    {
        return null;
    }

    public function getReviewStatusAttribute()
    {
        return null;
    }

    public function applicationForm()
    {
        return $this->forms()
            ->where('form_type_id', FormType::teamApplicationFormId())
            ->whereNotNull('form_type_id')
            ->whereNotNull('published_at')
            ->first();
    }

    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    public function getOwnerAttribute()
    {
        return $this->owners()
            ->first();
    }

    //** Memberships and Roles  **//

    //    public function owner()
    //    {
    //        return $this->morphOne(Membership::class, 'model')
    //                    ->where('role_id', $this->getRoleByName(config('platform.teams.default_owner_role'))
    //                                           ->id);
    //    }

    public function owners()
    {
        return $this->users()
            ->whereHas('roles', function ($query) {
                $query->where('name', config('platform.teams.default_owner_role'))
                    ->where('roles.team_id', $this->id);
            })->limit(1);
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'model', 'model_has_roles')
            ->withPivot('role_id')
            ->withTimestamps()
            ->as('membership');
    }

    public function members(): BelongsToMany
    {
        $roleId = $this->getRoleByName(config('platform.teams.default_owner_role'))?->id;

        return $this->users()
            ->wherePivotNotIn('role_id', [$roleId]);
    }

    public function getRoleByName($roleName)
    {
        return $this->roles()
            ->where('name', $roleName)
            ->first();
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function admins()
    {
        $roleId = $this->getRoleByName(config('platform.teams.default_admin_role'))->id;

        return $this->users()
            ->wherePivotIn('role_id', [$roleId]);
    }

    public function allUsers()
    {
        return $this->users();
    }

    public function applicationsCount()
    {
        return $this->teamApplications()
            ->count();
    }

    /**
     * Get all of the pending user applications for the team.
     */
    public function teamApplications(): HasMany
    {
        return $this->hasMany(TeamApplication::class);
    }

    public function hasUserWithEmail(string $email)
    {
        return $this->allUsers->contains(function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    public function profile(): string
    {
        return route('catalyst-social.teams.show', $this);
    }

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function teamPlans(): HasMany
    //{
    //    return $this->hasMany(TeamPlan::class);
    //}

    // Scopes //

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    public function scopeWithUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('users', function ($query) use ($user) {
            $query->where('model_has_roles.model_id', $user->id)
                ->where('model_has_roles.model_type', User::class);
        });
    }

    public function hasStripeConnectAccount(): bool
    {
        return ! empty($this->stripe_connect_id);
    }

    public function stripeConnectOnboardingCompleted(): bool
    {
        return (bool) $this->stripe_connect_onboarding_completed;
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function subscribersCount(): int
    {
        return Subscription::where('team_id', $this->id)
            ->count();
    }

    public function notify($value)
    {
        return $this->owner->notify($value);
    }

    /**
     * Jobs
     */
    /**
     * @return HasMany
     */
    public function jobs()
    {
        return $this->hasMany(JobPosition::class);
    }

    /**
     * Check if the company is default or not.
     *
     * @return mixed
     */
    public function isDefaultCompany()
    {
        return $this->personal_team;
    }
}
