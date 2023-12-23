<?php

namespace OmniaDigital\CatalystCore\Livewire\Components\Calendar\Partials;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\CatalystCore\Livewire\Components\Events\Location;
use OmniaDigital\CatalystCore\Models\Event;
use OmniaDigital\CatalystCore\Support\Livewire\InteractsWithCalendarTeams;
use OmniaDigital\CatalystCore\Traits\Filter\WithSortAndFilters;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class EventCalendarListPartial extends Component
{
    use WithCachedRows;
    use WithPagination;
    use WithSortAndFilters;
    use InteractsWithCalendarTeams;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date',
    ];

    public string $dateColumn = 'start_date';

    public Event $event;

    public ?string $classes = '';

    public function mount($classes = ''): void
    {
        $this->classes = $classes;
        $this->orderBy = 'name';

        if (!App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function getRowsQueryProperty(): Builder
    {
        $query = Event::query();

        $query = $this->applyFilters($query);
        $query = $this->applySorting($query);

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function getUserProperty()
    {
        return User::find(auth()->id());
    }

    public function getPlacesProperty()
    {
        $places = Location::query()
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $location) {
                return [
                    'id' => $location->id,
                    'name' => $location->model->name,
                    'lat' => $location->lat,
                    'lng' => $location->lng,
                    'address' => $location->address,
                    'address_line_2' => $location->address_line_2,
                    'city' => $location->city,
                    'state' => $location->state,
                    'postal_code' => $location->postal_code,
                    'country' => $location->country,
                ];
            });

        return $places->all();
    }

    #[On('eventSelected')]
    public function handleEventSelected($eventId): void
    {
        $this->selectEvent($eventId);

        $this->dispatch(event: 'select-event', params: $this->event);
    }

    public function selectEvent($eventID): void
    {
        $this->event = Event::find($eventID);
    }

    public function moreInfo(): RedirectResponse
    {
        return redirect()->route('catalyst-social.events.show', $this->event);
    }

    public function toggleMapCalendar($tab): void
    {
        $this->dispatch('toggle_map_calendar', tab: $tab, places: $this->places);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('catalyst::livewire.components.calendar-event-list', [
            'events' => $this->rows,
            'eventsCount' => $this->rowsQuery->count(),
        ]);
    }
}
