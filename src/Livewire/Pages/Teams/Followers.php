<?php

namespace OmniaDigital\CatalystSocialPlugin\Livewire\Pages\Teams;

use App\Models\Team;
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
        return view('catalyst-social::livewire.pages.teams.followers');
    }
}
