<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Teams;

use OmniaDigital\CatalystCore\Models\Team;
use Livewire\Component;

class Followers extends Component
{
    public $team;

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function render()
    {
        return view('catalyst::livewire.pages.teams.followers');
    }
}
