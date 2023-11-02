<?php

namespace OmniaDigital\CatalystCore\Observers;

use OmniaDigital\CatalystCore\Models\User;

class UserObserver
{
    public function created(User $user)
    {
    }

    public function updated(User $user)
    {
        //
    }

    public function deleted(User $user)
    {
        //
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
