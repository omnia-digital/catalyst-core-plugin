<?php

namespace OmniaDigital\CatalystCore\Livewire\Components\Teams;

use App\Models\ContactCategory;
use Illuminate\Support\Arr;
use Livewire\Component;
use Squire\Models\Country;

class MapGoogle extends Component
{
    public $selectedCategoryId = 'All';

    public $filters = [
        'country',
    ];

    public function updatedFilters($value, $key)
    {
        //$this->dispatch('refresh-map', $this->rows);

        if ($key === 'country' && $value !== 'All') {
            $this->dispatch('focus-to-country', value: strtoupper($value));
        }
    }

    public function selectCategory($id)
    {
        $this->selectedCategoryId = $id;

        $this->dispatch('refresh-map', rows: $this->rows);
    }

    public function getCategoriesProperty()
    {
        return ['Category 1', 'Category 2', 'Category 3']; //ContactCategory::all();
    }

    public function getRowsQueryProperty()
    {
        $country = Arr::get($this->filters, 'country');

        return null; /* Contact::query()
            ->with('contactCategories')
            ->available()
            ->when($this->selectedCategoryId && $this->selectedCategoryId !== 'All', fn($query, $category) => $query->whereHas('contactCategories', fn($query) => $query->where('contact_category_id', $this->selectedCategoryId)))
            ->when(!empty($country) && $country !== 'All', fn($query) => $query->where('country', $country)); */
    }

    public function getRowsProperty()
    {
        return null; //$this->rowsQuery->get();
    }

    public function render()
    {
        return view('catalyst-social::livewire.components.teams.map_google', [
            'countries' => Country::orderBy('name')->get(),
        ]);
    }
}
