<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Profiles;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Traits\Filter\WithSortAndFilters;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Teams extends Component
{
    use WithCachedRows;
    use WithPagination;
    use WithSortAndFilters;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date',
    ];

    public string $dateColumn = 'start_date';

    public $profile;

    public function getUserProperty()
    {
        return $this->profile->user;
    }

    public function mount(Profile $profile)
    {
        $this->profile = $profile->load('user');

        $this->orderBy = 'name';

        if (! App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function getRowsQueryProperty()
    {
        $query = Team::query()
            ->withUser($this->user)
            ->withCount(['users']);

        $query = $query->when($this->search, fn (Builder $q) => $q->search($this->search));
        $query = $this->applySorting($query);

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function render()
    {
        return view('catalyst-social::livewire.pages.profiles.teams', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count(),
        ]);
    }
}
