<?php

namespace OmniaDigital\CatalystCore\Livewire;

use OmniaDigital\CatalystCore\Livewire\Form as LivewireForm;
use OmniaDigital\CatalystCore\Models\Form;
use OmniaDigital\CatalystCore\Models\FormSubmission;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\TeamApplication;
use OmniaDigital\CatalystCore\Traits\Team\WithTeamManagement;

class TeamApplicationForm extends LivewireForm
{
    use WithTeamManagement;

    public Team $team;

    public ?Form $applicationForm;

    public function mount(Form $form, int $team_id = null, $submitText = 'Submit')
    {
        $this->team = Team::find($team_id);

        parent::mount($form, $team_id, $submitText);

        $this->applicationForm = $form;
    }

    public function processFormSubmission($formData)
    {
        $this->applyToTeam();

        $application = TeamApplication::query()
            ->where('user_id', $this->user->id)
            ->where('team_id', $this->team_id)
            ->first();

        $formSubmission = FormSubmission::create([
            'form_id' => $this->formModel->id,
            'user_id' => $this->user->id,
            'team_id' => $this->team_id ?? null,
            'data' => $formData,
        ]);

        $application->update(['form_submission_id' => $formSubmission->id]);
    }

    public function afterSubmission()
    {
        $this->redirectroute('catalyst-social.teams.show', $this->team);
    }
}
