<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Profiles;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Profile;

class Show extends Component
{
    public $profile;

    public $additionalInfo = [
        'likes',
        'views',
        'comments',
        'volunteers',
        'members',
    ];

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
        return view('catalyst::livewire.pages.profiles.show');
    }
}
