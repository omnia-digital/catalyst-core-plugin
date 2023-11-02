<?php

namespace OmniaDigital\CatalystCore\Livewire\Partials;

use Livewire\Component;

class SearchComponent extends Component
{
    public $search = '';

    public $placeholder = 'Search';

    public function render()
    {
        return view('catalyst::livewire.partials.search-component');
    }
}
