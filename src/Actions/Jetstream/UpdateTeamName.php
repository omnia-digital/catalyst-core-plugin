<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;

class UpdateTeamName implements UpdatesTeamNames
{
    /**
     * Validate and update the given team's name.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, Team $team, array $input): void
    {
        Gate::forUser($user)->authorize('update', $team);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateTeamName');

        $team->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}
