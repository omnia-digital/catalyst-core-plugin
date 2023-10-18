<?php

namespace OmniaDigital\CatalystCore\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
