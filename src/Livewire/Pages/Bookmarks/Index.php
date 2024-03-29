<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Bookmarks;

use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystCore\Models\Bookmark;
use OmniaDigital\CatalystCore\Traits\Filter\WithSortAndFilters;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Index extends Component
{
    use WithCachedRows;
    use WithGuestAccess;
    use WithPagination;
    use WithSortAndFilters;

    public ?string $search = null;

    public array $sortLabels = [
        'created_at' => 'Date Created',
    ];

    public string $dateColumn = 'created_at';

    protected $queryString = [
        'search',
    ];

    public function mount()
    {
        $this->orderBy = 'created_at';
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Bookmark::where('user_id', '=', auth()->user()?->id);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function showGuestAccessModal()
    {
        if (Catalyst::isAllowingGuestAccess() && ! auth()->check()) {
            $this->showAuthenticationModal(route('catalyst-social.bookmarks'));
        }
    }

    public function render()
    {
        return view('catalyst::livewire.pages.bookmarks.index', [
            'bookmarks' => $this->rows,
        ]);
    }
}
