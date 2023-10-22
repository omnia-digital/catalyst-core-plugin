<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Teams\Forms;

use App\Models\Team;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use OmniaDigital\CatalystCore\Traits\Livewire\WithFormBuilder;

class Builder extends Component implements HasForms
{
    use WithFormBuilder;

    public Team $team;

    public $formModel;

    public function mount(Team $team, $form = null)
    {
        $this->team = $team;

        if ($form) {
            $this->formModel = Form::find($form);
            $this->form->fill($this->formModel->toArray());
        }
    }

    public function render()
    {
        return view('catalyst::livewire.pages.teams.forms.builder');
    }
}
