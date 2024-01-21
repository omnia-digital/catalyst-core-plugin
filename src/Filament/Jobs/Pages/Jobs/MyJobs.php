<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs;

use Filament\Pages\Page;
use Livewire\Component;
use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;

class MyJobs extends BasePage
{
    protected static string $view = 'catalyst::filament.jobs.pages.jobs.my-jobs';

    protected static bool $shouldRegisterNavigation = true;

    public function getViewData(): array
    {
        $jobs = auth()->user()->currentTeam
            ->jobs()
            ->latest()
            ->get()
            ->sortByDesc(['is_active', 'created_at']);

        return [
            'jobs' => $jobs,
        ];
    }
}
