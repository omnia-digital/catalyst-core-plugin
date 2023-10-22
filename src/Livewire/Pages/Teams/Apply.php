<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Teams;

use App\Models\Team;
use OmniaDigital\CatalystCore\Traits\Team\WithTeamManagement;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Form;

class Apply extends Component
{
    use WithTeamManagement;

    public Team $team;

    public ?Form $applicationForm;

    public function mount(Team $team)
    {
        Gate::authorize('apply', $this->team);

        $this->team = $team;

        if (! $this->teamHasApplicationForm()) {
            $this->applyToTeam();

            $this->redirectroute('catalyst-social.teams.show', $this->team);
        }

        $this->applicationForm = $this->team->applicationForm();
    }

    public function render()
    {
        return view('catalyst::livewire.pages.teams.apply');
    }
}
