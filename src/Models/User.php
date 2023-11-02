<?php

namespace OmniaDigital\CatalystCore\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OmniaDigital\CatalystCore\Database\Factories\UserFactory;
use OmniaDigital\CatalystCore\Traits\CatalystUserTraits;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use CatalystUserTraits;

    protected static function newFactory()
    {
        return app(UserFactory::class);
    }
}
