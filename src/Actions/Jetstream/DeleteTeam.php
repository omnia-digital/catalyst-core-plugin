<?php

namespace OmniaDigital\CatalystCore\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesTeams;
use OmniaDigital\CatalystCore\Models\Team;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        $team->purge();
    }
}
