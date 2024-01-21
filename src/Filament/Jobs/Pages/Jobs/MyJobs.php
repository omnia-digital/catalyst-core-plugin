<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\CreateAction;
use Filament\Pages\Page;
use Livewire\Component;
use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;

class MyJobs extends BasePage
{
    use InteractsWithActions;

    protected static string $view = 'catalyst::filament.jobs.pages.jobs.my-jobs';

    protected static bool $shouldRegisterNavigation = true;

    public function getViewData(): array
    {
        $jobs = auth()->user()->currentTeam
            ->jobs()
            ->with(['company', 'skills', 'addons'])
            ->latest()
            ->get()
            ->sortByDesc(['is_active', 'created_at']);

        return [
            'jobs' => $jobs,
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            CreateAction::make('create')
                ->url(route('filament.jobs.pages.new-job'))
                ->color('blue')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
