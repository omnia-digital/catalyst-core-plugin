<?php

namespace OmniaDigital\CatalystCore\Livewire\Partials;

use OmniaDigital\CatalystCore\Models\User;
use Livewire\Component;

class WhoToFollowSection extends Component
{
    public function getUsersQueryProperty()
    {
        return User::query()->with(['profile']);
    }

    public function getWhoToFollowProperty()
    {
        return $this
            ->usersQuery
            ->withCount(['followers'])
            ->where('id', '<>', auth()->id())
            ->orderBy('followers_count', 'desc')
            ->distinct()
            ->limit(3)->get();
    }

    public function render()
    {
        return view('catalyst::livewire.partials.who-to-follow-section');
    }
}
