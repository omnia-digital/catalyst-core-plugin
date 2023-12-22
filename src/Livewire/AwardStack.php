<?php

namespace OmniaDigital\CatalystCore\Livewire;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Team;
use App\Models\User;

class AwardStack extends Component
{
    public $user;

    public $awards;

    public ?Team $team = null;

    public function mount(User $user, Team $team = null)
    {
        $this->user = $user;
        $this->awards = $user->awards()->take(3)->get();
        $this->team = $team;
    }

    public function render()
    {
        return view('catalyst::livewire.award-stack');
    }
}
