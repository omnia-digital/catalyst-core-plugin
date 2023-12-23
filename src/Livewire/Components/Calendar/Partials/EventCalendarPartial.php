<?php

namespace OmniaDigital\CatalystCore\Livewire\Components\Calendar\Partials;

use App\Models\User;
use Illuminate\Support\Collection;
use Omnia\LivewireCalendar\LivewireCalendar;
use OmniaDigital\CatalystCore\Models\Event;

class EventCalendarPartial extends LivewireCalendar
{
//    use InteractsWithCalendarEvents;

    public $id = 'calendar';

    public $selectedID;

    protected $listeners = ['select_event' => 'goToMonth'];

    public function events(): Collection
    {
        return Event::query()->publicAndPublished()
            ->whereDate('starts_at', '>=', $this->gridStartsAt)
            ->whereDate('starts_at', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'description' => $event->summary,
                    'date' => $event->starts_at,
                    'count' => $event->followers()->count(),
                    'location' => $event->location,
                ];
            });
    }
    public function goToMonth($eventID)
    {
        $this->selectedID = $eventID;
        $date = Event::find($eventID)->start_date;

        $this->startsAt = $date->startOfMonth()->startOfDay();
        $this->endsAt = $this->startsAt->clone()->endOfMonth()->startOfDay();

        $this->calculateGridStartsEnds();
    }

    public function onEventClick($eventId)
    {
        $this->dispatch('eventSelected', eventId: $eventId)->to('catalyst::components.events.event-calendar-list');
    }

    public function getUserProperty()
    {
        return User::find(auth()->id());
    }
}