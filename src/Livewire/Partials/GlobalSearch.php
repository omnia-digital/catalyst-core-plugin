<?php

namespace OmniaDigital\CatalystCore\Livewire\Partials;

use Illuminate\Support\Collection;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Support\GlobalSearch\GlobalSearch as Search;
use Spatie\Searchable\SearchResultCollection;

class GlobalSearch extends Component
{
    public ?string $search = null;

    public SearchResultCollection | Collection $searchResults;

    public function updatedSearch($value)
    {
        if (empty($value)) {
            $this->searchResults = new SearchResultCollection;

            return;
        }

        $this->searchResults = (new Search)
            ->registerModel(Post::class, 'title')
            ->registerModel(Team::class, 'name', 'handle')
            ->registerModel(Profile::class, 'first_name', 'last_name', 'handle')
            ->search($value);
    }

    public function render()
    {
        return view('livewire.partials.global-search');
    }
}
