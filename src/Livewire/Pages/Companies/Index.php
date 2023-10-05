<?php

namespace App\Livewire\Pages\Companies;

use App\Traits\Filter\WithSortAndFilters;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\CatalystCore\Actions\Companies\GetCompanyCategoriesAction;
use OmniaDigital\CatalystCore\Lenses\WithLenses;
use OmniaDigital\CatalystCore\Models\Company;

class Index extends Component
{
    use WithLenses;
    use WithPagination;
    use WithSortAndFilters;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
    ];

    public string $dateColumn = 'start_date';

    public ?string $lens = null;

    protected $queryString = [
        'lens',
        'filters',
        'tags',
        'members',
        'dateFilter',
    ];

    public function mount()
    {
        $this->orderBy = 'name';
    }

    public function getRowsQueryProperty()
    {
        $query = Company::query();
        //            ->with('location')
        //            ->withCount('users');

        return $this->applyFilters($query)
            ->when($this->search, fn (Builder $q) => $q->search($this->search));
    }

    public function getRowsProperty()
    {
        $query = $this->applyLens($this->rowsQuery);
        $query = $this->applySorting($query);

        return $query->paginate(25);
    }

    public function getCategoriesProperty()
    {
        return [];
        //        return (new GetCompanyCategoriesAction)->execute();
    }

    public function render()
    {
        return view('livewire.pages.companies.index', [
            'companies' => $this->rows,
            'allTags' => $this->allTags,
            'categories' => $this->categories,
        ]);
    }
}
