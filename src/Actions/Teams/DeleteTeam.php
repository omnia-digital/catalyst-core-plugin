<?php

namespace OmniaDigital\CatalystCore\Actions\Teams;

use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     *
     * @param  mixed  $team
     * @return void
     */
    public function delete($team)
    {
        $team->purge();
    }
}
