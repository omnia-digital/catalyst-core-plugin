<?php

namespace OmniaDigital\CatalystCore\Livewire\Partials;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;

class UserStatusList extends Component
{
    public ?Team $team = null;

    public function getUsersQueryProperty()
    {
        return User::query();
    }

    public function getUserListProperty()
    {
        $query = $this
            ->usersQuery
            ->withCount(['followers'])
            ->distinct();

        if ($this->team) {
            $query = $this->forTeam($query, $this->team);
        }

        return $query->get();
    }

    public function forTeam($query, Team $team)
    {
        return $query
            ->whereHas('teams', function ($query) use ($team) {
                $query->where('model_has_roles.team_id', $team->id);
            });
    }

    public function render()
    {
        return view('social::livewire.partials.user-status-list');
    }
}
