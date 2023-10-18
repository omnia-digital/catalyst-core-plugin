<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Profiles;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Profile;

class Media extends Component
{
    public $profile;

    public $media;

    public function getUserProperty()
    {
        return $this->profile->user;
    }

    public function mount(Profile $profile)
    {
        $this->profile = $profile->load('user');
        $this->media = $this->user->postMedia;
    }

    public function render()
    {
        return view('catalyst-social::livewire.pages.profiles.media');
    }
}
