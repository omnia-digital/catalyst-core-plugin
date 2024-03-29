<?php

namespace OmniaDigital\CatalystCore\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class MainNavLeft extends Component
{
    public $navigation;

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('catalyst::livewire.main-nav-left');
    }
}
