<?php

namespace OmniaDigital\CatalystSocialPlugin\Livewire\Pages\Profiles;

use Livewire\Component;
use OmniaDigital\CatalystSocialPlugin\Models\Profile;

class Followers extends Component
{
    public Profile $profile;

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
        return view('catalyst-social::livewire.pages.profiles.followers');
    }
}
