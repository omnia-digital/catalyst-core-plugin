<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Components\Teams;

use Omnia\LivewireCalendar\LivewireCalendar;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;
use OmniaDigital\CatalystCore\Support\Livewire\InteractsWithCalendarTeams;

class TeamCalendar extends LivewireCalendar
{
    use InteractsWithCalendarTeams;

    public $selectedID;

    protected $listeners = ['select_event' => 'goToMonth'];

    public function goToMonth($eventID)
    {
        $this->selectedID = $eventID;
        $date = Team::find($eventID)->start_date;

        $this->startsAt = $date->startOfMonth()->startOfDay();
        $this->endsAt = $this->startsAt->clone()->endOfMonth()->startOfDay();

        $this->calculateGridStartsEnds();
    }

    public function onEventClick($eventId)
    {
        $this->dispatch('teamSelected', eventId: $eventId)->to('social::components.teams.team-calendar-list');
    }

    public function getUserProperty()
    {
        return User::find(auth()->id());
    }

    public function render()
    {
        return view('social::livewire.components.teams.team-calendar');
    }
}
