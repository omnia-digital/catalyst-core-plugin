<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Components\Teams;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Team;

class TeamCard extends Component
{
    public $team;

    public function mount(Team $team)
    {
        $this->team = $team->load('teamTypes');
    }

    public function showTeam()
    {
        return redirect($this->team->profile());
    }

    public function render()
    {
        return view('social::livewire.components.teams.team-card');
    }
}
