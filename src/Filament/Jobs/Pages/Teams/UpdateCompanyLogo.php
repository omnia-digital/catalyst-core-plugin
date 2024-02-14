<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Teams;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateCompanyLogo extends Component
{
    use WithFileUploads;

    public $company;

    public $photo;

    protected $rules = [
        'photo' => ['nullable', 'image', 'max:1024'],
    ];

    protected $listeners = [
        'logo-removed' => '$refresh',
    ];

    public function mount($company)
    {
        $this->company = $company;
    }

    /**
     * Update company logo
     *
     * @return RedirectResponse|void
     *
     * @throws AuthorizationException
     */
    public function updateCompanyLogo()
    {
        Gate::forUser(auth()->user())->authorize('update', $this->company);

        $this->validate();

        if ($this->photo) {
            $this->company->updateLogo($this->photo);

            return redirect()->route('teams.show', $this->company->id);
        }
    }

    public function deleteCompanyLogo()
    {
        auth()->user()->currentTeam->deleteLogo();

        $this->dispatch('logo-removed')->self();
    }

    public function render()
    {
        return view('teams.update-company-logo');
    }
}
