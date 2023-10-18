<?php

namespace OmniaDigital\CatalystSocialPlugin\Livewire\Components;

use Livewire\Component;

/**
 * @property array $places
 */
class FindTeams extends Component
{
    public ?string $startDate = null;

    public function updatedStartDate()
    {
        $component = $this->current === 'map'
            ? 'catalyst-social::components.team-map'
            : 'catalyst-social::components.current-week-team-calendar';

        $this->dispatch('startDateUpdated', start_date: $this->startDate)->to($component);
    }

    public function render()
    {
        return view('catalyst-social::livewire.components.find-teams');
    }
}
