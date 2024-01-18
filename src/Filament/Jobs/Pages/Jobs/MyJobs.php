<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs;

use Filament\Pages\Page;
use Livewire\Component;

class MyJobs extends Page
{
    protected static string $view = 'catalyst-jobs::filament.pages.jobs.my-jobs';

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
