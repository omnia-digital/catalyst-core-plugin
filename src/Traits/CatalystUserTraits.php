<?php

namespace OmniaDigital\CatalystCore\Traits;

use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Laravel\Cashier\Billable;
use Laravel\Cashier\SubscriptionBuilder;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasTeams as JetstreamHasTeams;
use OmniaDigital\CatalystCore\Actions\Fortify\CreateNewUser;
use OmniaDigital\CatalystForms\Models\FormSubmission;
use OmniaDigital\CatalystCore\Models\Like;
use OmniaDigital\CatalystCore\Models\Media;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Models\TeamApplication;
use OmniaDigital\CatalystCore\Models\TeamInvitation;
use OmniaDigital\CatalystCore\Traits\Profile\Profileable;
use OmniaDigital\CatalystCore\Traits\Team\HasTeams;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasRoles;
use Stripe\Review;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;

trait CatalystUserTraits
{
    use Profileable;
    use Billable;
    use Followable;
    use Follower;
    use Awardable;
    //    use HasJobs;
    //    use HasNotificationSubscriptions;
    use HasBookmarks;
    use HasFactory;

    use HasHandle;

    use HasRoles;
//    use HasPanelShield;
    use HasTeams, JetstreamHasTeams {
        HasTeams::teams insteadof JetstreamHasTeams;
        HasTeams::hasTeamRole insteadof JetstreamHasTeams;
        HasTeams::isCurrentTeam insteadof JetstreamHasTeams;
        HasTeams::ownsTeam insteadof JetstreamHasTeams;
        HasTeams::ownedTeams insteadof JetstreamHasTeams;
        HasTeams::currentTeam insteadof JetstreamHasTeams;
        HasTeams::teamRole insteadof JetstreamHasTeams;
    }

    //    use HasTransactions;
    use Notifiable;
    use SnoozeNotifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;
    //    use WithChargentSubscriptions;

    public static function findByFullName($firstName = '', $lastName = '', $fullName = '')
    {
        if (! empty($fullName) && empty($firstName) && empty($lastName)) {
            $names = explode(' ', $fullName);
            $firstName = $names[0] ?? '';
            $lastName = $names[1] ?? '';
        }

        return User::whereHas('profile', function ($query) use ($firstName, $lastName) {
            $query->where('first_name', $firstName)
                ->where('last_name', $lastName);
        })->first();
    }

    public static function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public static function findByHandle($handle)
    {
        return User::with('profile')
            ->whereHas('profile', function ($q) use ($handle) {
                $q->where('handle', $handle);
            })->first();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        if ($this->is_admin) {
            return true;
        }

        return str_ends_with($this->email, '@omniadigital.io') && $this->hasVerifiedEmail();
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole('super_admin');
    }

    /// Routes ///

    /**
     * Route notifications for the Vonage channel.
     */
    public function routeNotificationForVonage(Notification $notification): string
    {
        return $this->phone;
    }

    //// Attributes ////

    public function getHandleAttribute()
    {
        $this->load('profile');

        return $this->profile?->handle;
    }

    public function getNameAttribute()
    {
        if (!class_exists(Profile::class)) {
            return;
        }

        $this->load('profile');

        return $this->profile?->name;
    }

    public function getFirstNameAttribute()
    {
        if (!class_exists(Profile::class)) {
            return;
        }
        $this->load('profile');

        return $this->profile?->first_name;
    }

    public function getLastNameAttribute()
    {
        if (!class_exists(Profile::class)) {
            return;
        }
        $this->load('profile');

        return $this->profile?->last_name;
    }

    public function getContactIdAttribute()
    {
        if (!class_exists(Profile::class)) {
            return;
        }
        $this->load('profile');

        return $this->profile?->salesforce_contact_id;
    }

    public function getProfilePhotoUrlAttribute()
    {
        if (!class_exists(Profile::class)) {
            return;
        }
        $this->load('profile');

        if (empty($this->profile)) {
            $createNewUser = new CreateNewUser();
            $this->profile = $createNewUser->createProfile($this, [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
            ]);
        }

        return $this->profile->profile_photo_url;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_photo_url;
    }

    public function getOnlineStatusAttribute()
    {
        return true;
    }

    public function deleteProfilePhoto()
    {
        $this->profile->deleteProfilePhoto();
    }

    //// Relations ////

    public function roles(): BelongsToMany
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            PermissionRegistrar::$pivotRole
        );
    }

    public function profile()
    {
        if (! class_exists(Profile::class)) {
            return;
        }

        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        if (! class_exists(Post::class)) {
            return;
        }

        return $this->hasMany(Post::class);
    }

    public function reviews()
    {
        if (! class_exists(Review::class)) {
            return;
        }

        return $this->hasMany(Review::class);
    }

    public function likes()
    {
        if (! class_exists(Like::class)) {
            return;
        }

        return $this->hasMany(Like::class);
    }

    public function likedPosts()
    {
        return $this->likes->map->post->flatten();
    }

    public function postMedia()
    {
        return $this->hasManyThrough(Media::class, Post::class, 'user_id', 'model_id')
            ->where('model_type', Post::class);
    }

    public function teamInvitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    public function teamApplications(): HasMany
    {
        return $this->hasMany(TeamApplication::class);
    }

    public function formSubmissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }

    //// Helper Methods ////

    public function url()
    {
        return route('catalyst-social.profile.show', $this->handle);
    }

    /**
     * Begin creating a new subscription.
     *
     * @param  string  $name
     * @param  string|string[]  $prices
     * @return SubscriptionBuilder
     */
    public function newSubscription($name, $prices = [])
    {
        return new CashierSubscriptionBuilder($this, $name, $prices);
    }

    public function canManageSettings()
    {
        return $this->is_admin;
    }

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function stripeConnectCustomers(): HasMany
    //{
    //    return $this->hasMany(StripeConnectCustomer::class);
    //}

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function isStripeConnectCustomerOf(Team $team): bool
    //{
    //    return $this->stripeConnectCustomers->where('team_id', $team->id)->isNotEmpty();
    //}

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function stripeConnectCustomerOf(Team $team): ?StripeConnectCustomer
    //{
    //    return $this->stripeConnectCustomers()
    //        ->where('team_id', $team->id)
    //        ->first();
    //}
}
