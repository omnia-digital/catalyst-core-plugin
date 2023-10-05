<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Pages\Teams\Forms;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Form;
use OmniaDigital\CatalystCore\Models\FormSubmission;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Traits\Team\WithTeamManagement;

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
        return view('social::livewire.pages.teams.forms.submissions');
    }
}
