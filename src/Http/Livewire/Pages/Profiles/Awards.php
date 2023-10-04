<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Pages\Profiles;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Profile;

class Awards extends Component
{
    public $profile;

    public function getUserProperty()
    {
        return $this->profile->user;
    }

    public function mount(Profile $profile)
    {
        $this->profile = $profile->load('user');
    }

    public function render()
    {
        return view('social::livewire.pages.profiles.awards');
    }
}