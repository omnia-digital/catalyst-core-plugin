<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages;

use Livewire\WithPagination;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystCore\Traits\Filter\WithSortAndFilters;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Home extends BasePage
{
    use WithCachedRows,
        WithGuestAccess,
        WithPagination, WithSortAndFilters;

//    use HasPageShield;

    protected static string $view = 'catalyst::filament.jobs.pages.home';

    protected static bool $shouldRegisterNavigation = true;
//    protected static bool $showTitle = false;
    protected static bool $showBackButton = false;

    public $perPage = 25;

    public $loadMoreCount = 25;

    public array $sortLabels = [
        'title' => 'title',
    ];

    public string $dateColumn = 'created_at';

    public function getViewData(): array
    {
        $featuredJobs = JobPosition::with(['company', 'skills', 'addons'])
            ->featured(Catalyst::getJobSetting('featured_days', 30))
            ->active()
            ->latest()
            ->when(Catalyst::getJobSetting('featured_jobs_limit'), fn($query, $limit) => $query->take($limit))
            ->get();

        $jobs = JobPosition::with(['company', 'skills', 'addons'])
            ->whereNotIn('id', $featuredJobs->pluck('id'))
            ->active()
            ->latest()
            ->get();

        return [
            'jobs' => $jobs,
            'featuredJobs' => $featuredJobs,
        ];
    }
}
