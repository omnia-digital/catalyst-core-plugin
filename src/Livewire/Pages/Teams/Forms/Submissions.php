<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Teams\Forms;

use App\Models\Team;
use OmniaDigital\CatalystCore\Traits\Team\WithTeamManagement;
use Livewire\Component;
use Modules\Forms\Models\Form;
use Modules\Forms\Models\FormSubmission;

class Submissions extends Component
{
    use WithTeamManagement;

    public Team $team;

    public Form $form;

    public FormSubmission $selectedSubmission;

    public function mount(Team $team, Form $form)
    {
        $this->team = $team;

        $this->form = $form;

        $this->selectedSubmission = $form->submissions()->first();
    }

    public function updateCurrentSelected(FormSubmission $submission)
    {
        $this->selectedSubmission = $submission;
    }

    public function render()
    {
        return view('catalyst-social::livewire.pages.teams.forms.submissions');
    }
}
