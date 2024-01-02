<?php

namespace OmniaDigital\CatalystCore\Livewire\Components\Calendar\Partials;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Omnia\LivewireCalendar\LivewireCalendar;
use OmniaDigital\CatalystCore\Models\Event;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;

class EventCalendarPartial extends LivewireCalendar
{
//    use InteractsWithCalendarEvents;
    use WithCachedRows;

    public $id = 'calendar';

    public $selectedID;

    protected $listeners = ['select_event' => 'goToMonth'];

    public function events(): Collection
    {
        // @TODO [Josh] - add a way to pull in multiple google calendars from database and merge the events into one collection so we can display them all on our calendar

        // @TODO [Josh] - have a way to show game releases as well with a filter, maybe setup another google calendar

//        pull in events from different google calendars and display them on our calendar
//        if we want users to sync with our google calendars though, we have to add those events to each type of calendar
//        we need to have an event_type attribute
//        maybe an event_source attribute as well
//        manually added events will be in our database, but we need to sync them with a specific google calendar as well
//        calendars we need:
//            - conferences
//            - game jams
//            - game releases
//            - deadlines
//            - showcases
//            - meetups

//        need to have a way to have events go multiple days

//        how often do we need to sync with google calendars?
//          - nightly
//          - have a way to manually sync
//        - need to have a relation from an event to one or more SourceCalendars

        $hatchetGameDevCalendarId = 'fecb920d906f2aa7e96c9a90ffeffd348e0d3aaa77eecb02c90190ae878e843a@group.calendar.google.com';
        $gameConfGuideDeadlinesCalendarId = 'c_5pfaoq4h96ljtue6mr6c93d94k@group.calendar.google.com';
        $gameConfGuideShowcasesCalendarId = 'c_6796064a82632176ae9f0dfbfc261f0987279483d8a98be357703c30a9d48785@group.calendar.google.com';
        $gameConfGuideConferencesCalendarId = 'c_6fptt3lh5ju30nkvf0oa402dhk@group.calendar.google.com';
//https://www.gameconfguide.com/about/
        $hatchetEvents = GoogleCalendarEvent::get(calendarId: $hatchetGameDevCalendarId)->map(function (GoogleCalendarEvent $event) {
            return [
                'id' => $event->id,
                'title' => $event->name,
                'description' => $event->summary,
                'date' => $event->start->date,
                'count' => 1,
                'location' => $event->location,
            ];
        });
        $gameConfGuideCalendarIds = [
            $gameConfGuideDeadlinesCalendarId,
            $gameConfGuideShowcasesCalendarId,
            $gameConfGuideConferencesCalendarId,
        ];
        foreach ($gameConfGuideCalendarIds as $calendarId) {
            $hatchetEvents = $hatchetEvents->merge(GoogleCalendarEvent::get(calendarId: $calendarId)->map(function (GoogleCalendarEvent $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'description' => $event->summary,
                    'date' => $event->start->date,
                    'count' => 1,
                    'location' => $event->location,
                ];
            }));
        }
        return $hatchetEvents;

        // get events in local DB
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
        $date = GoogleCalendarEvent::find($eventID)->start_date;

        $this->startsAt = $date->startOfMonth()->startOfDay();
        $this->endsAt = $this->startsAt->clone()->endOfMonth()->startOfDay();

        $this->calculateGridStartsEnds();
    }

    public function onEventClick($eventId)
    {
        $this->dispatch('eventSelected', eventId: $eventId)->to('catalyst::components.calendar.partials.event-calendar-list-partial');
    }

    public function getUserProperty()
    {
        return User::find(auth()->id());
    }
}
