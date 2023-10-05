<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Pages\Teams\Forms;

use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Form;
use OmniaDigital\CatalystCore\Models\Team;
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
        return view('social::livewire.pages.teams.forms.builder');
    }
}
