<?php

namespace OmniaDigital\CatalystCore\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use OmniaDigital\CatalystCore\Database\Factories\UserFactory;
use OmniaDigital\CatalystCore\Traits\CatalystUserTraits;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use CatalystUserTraits;
    use Follower;
    use Followable;

    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams->contains($tenant);
    }

    protected static function newFactory()
    {
        return app(UserFactory::class);
    }
}
