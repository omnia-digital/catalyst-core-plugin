<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Pages\Teams;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Team;

class Followers extends Component
{
    public $team;

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function render()
    {
        return view('social::livewire.pages.teams.followers');
    }
}
