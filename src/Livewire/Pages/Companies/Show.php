<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Companies;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Company;

class Show extends Component
{
    public $company;

    public function mount(Company $company)
    {
        $this->company = $company;

        visits($company)->increment();
    }

    public function render()
    {
        return view('livewire.pages.companies.show');
    }
}
