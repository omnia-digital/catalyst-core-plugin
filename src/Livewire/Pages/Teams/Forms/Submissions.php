<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Teams\Forms;

use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Traits\Team\WithTeamManagement;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Form;
use OmniaDigital\CatalystCore\Models\FormSubmission;

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
        return view('catalyst::livewire.pages.teams.forms.submissions');
    }
}
