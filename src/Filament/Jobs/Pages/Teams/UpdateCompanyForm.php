<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Teams;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;
use OmniaDigital\CatalystCore\Models\Company;
use OmniaDigital\CatalystCore\Models\Jobs\ApplyType;
use OmniaDigital\CatalystCore\Models\Jobs\ExperienceLevel;
use OmniaDigital\CatalystCore\Models\Jobs\HoursPerWeek;
use OmniaDigital\CatalystCore\Models\Jobs\JobPositionLength;
use OmniaDigital\CatalystCore\Models\Jobs\PaymentType;
use OmniaDigital\CatalystCore\Models\Jobs\ProjectSize;
use OmniaDigital\CatalystCore\Models\Team;

class UpdateCompanyForm extends BasePage
{
    public $company;

    public $state = [];

    protected static string $view = 'catalyst::filament.jobs.pages.teams.update-company-form';

    public static function getSlug():string
    {
        return 'update-company/{company}';
    }

    /**
     * Mount the component.
     *
     * @param  mixed  $company
     * @return void
     */
    public function mount(Team $company)
    {
        $this->company = $company;

        $this->state = ['about' => $company->about];
    }

    public function updateCompany()
    {
        $this->resetErrorBag();

        Gate::forUser($this->user)->authorize('update', $this->company);

        $this->company->update(['about' => $this->state['about'] ?? null]);

        $this->dispatch('saved');
    }

    public function getUserProperty()
    {
        return auth()->user();
    }

    public function getViewData(): array
    {
        return [
            'companies' => auth()->user()
                ->allTeams(),
            'applyTypes' => ApplyType::pluck('name', 'code'),
            'paymentTypes' => PaymentType::pluck('name', 'code'),
            'currentJobPositionSkills' => $this->job->skills->pluck('name', 'id'),
            'jobPositionSkillOptions' => $this->jobPositionSkillOptions,
            'jobLengths' => JobPositionLength::all(),
            'hoursPerWeek' => HoursPerWeek::pluck('value', 'id'),
            'experienceLevels' => ExperienceLevel::all(),
            'projectSizes' => ProjectSize::orderBy('order')->get()
        ];
    }
}
