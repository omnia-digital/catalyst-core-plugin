<?php

namespace OmniaDigital\CatalystCore\Livewire;

use Livewire\Component;

class MobileToolbarMenu extends Component
{
    public string $class;

    public $isOpen = false;

    public $navigation = [];

    public function mount()
    {
        if (empty($this->navigation)) {
            $this->navigation = [
                [
                    'label' => 'No Module Navigation Items',
                    'name' => 'social.home',
                    'icon' => 'x-mark',
                    'current' => false,
                ],
            ];
        }
    }

    public function openMobileMenu()
    {
        $this->isOpen = true;
    }

    public function closeMobileMenu()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('catalyst::livewire.mobile-toolbar-menu');
    }
}
