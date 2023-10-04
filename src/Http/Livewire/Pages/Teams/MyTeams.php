<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Models\User;
use App\Traits\Filter\WithSortAndFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystCore\Traits\Filter\WithSortAndFilters;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class MyTeams extends Component
{
    use WithCachedRows;
    use WithGuestAccess;
    use WithPagination;
    use WithSortAndFilters;

    public $perPage = 25;

    public $loadMoreCount = 25;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date',
    ];

    public string $dateColumn = 'start_date';

    public function mount()
    {
        if (Catalyst::isAllowingGuestAccess() && ! auth()->check()) {
            $this->redirectToAuthenticationPage();

            return;
        }

        $this->orderBy = 'name';

        if (! App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function getRowsQueryProperty()
    {
        $query = Team::query()
            ->withCount(['users']);

        $query = $this->applyFilters($query)
            ->when($this->search, fn (Builder $q) => $q->search($this->search));
        $query = $this->applySorting($query);

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate($this->perPage);
        });
    }

    public function getUserProperty()
    {
        return User::find(auth()->id());
    }

    public function loadMore()
    {
        $this->perPage += $this->loadMoreCount;
    }

    public function hasMore()
    {
        return $this->perPage < $this->rowsQuery->count();
    }

    public function render()
    {
        return view('social::livewire.pages.teams.my-teams', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count(),
        ]);
    }
}
