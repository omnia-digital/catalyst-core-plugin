<?php

namespace OmniaDigital\CatalystCore\Livewire\Components;

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
            ? 'catalyst::components.team-map'
            : 'catalyst::components.current-week-team-calendar';

        $this->dispatch('startDateUpdated', start_date: $this->startDate)->to($component);
    }

    public function render()
    {
        return view('catalyst::livewire.components.find-teams');
    }
}
