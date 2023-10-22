<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Teams;

use App\Models\Team;
use Livewire\Component;

class Awards extends Component
{
    public $team;

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function render()
    {
        return view('catalyst::livewire.pages.teams.awards');
    }
}
