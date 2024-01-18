<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs;

use Filament\Pages\Page;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;

class JobDetail extends Page
{
    protected static string $view = 'catalyst::jobs.filament.pages.jobs.job-detail';

    public $job;

    public function mount(JobPosition $job)
    {
        $this->job = $job;
    }

    public function getViewData(): array
    {
        return [];
    }
}
