<?php

namespace OmniaDigital\CatalystSocialPlugin\Livewire\Components\Teams;

use App\Models\Team;
use Livewire\Component;

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
        return view('catalyst-social::livewire.components.teams.team-card');
    }
}
