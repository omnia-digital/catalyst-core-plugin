<?php

namespace OmniaDigital\CatalystCore\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OmniaDigital\CatalystCore\Database\Factories\UserFactory;
use OmniaDigital\CatalystCore\Traits\CatalystUserTraits;
use Overtrue\LaravelFollow\Traits\Follower;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use CatalystUserTraits;
    use Follower;

    protected static function newFactory()
    {
        return app(UserFactory::class);
    }
}
