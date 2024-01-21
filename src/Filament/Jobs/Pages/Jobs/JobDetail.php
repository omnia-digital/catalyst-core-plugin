<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithRecord;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;

class JobDetail extends BasePage
{
    use InteractsWithRecord;

    protected static string $view = 'catalyst::filament.jobs.pages.jobs.job-detail';

    public $job;

    protected static ?string $slug = 'job';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(JobPosition $job)
    {
        $this->job = $job;
    }

    public function getViewData(): array
    {
        return [];
    }

}
