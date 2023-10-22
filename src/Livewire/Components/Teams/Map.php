<?php

namespace OmniaDigital\CatalystCore\Livewire\Components\Teams;

use App\Models\Location;
use App\Models\Team;
use Livewire\Component;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Map extends Component
{
    use WithMap;
    use WithNotification;

    public string | int | null $placeId = null;

    public $height = '500px';

    public $places = [];

    protected $listeners = [
        'select_event' => 'handleEventSelected',
    ];

    public function handleEventSelected($eventId)
    {
        $team = Team::find($eventId);

        if (! $team || ! ($location = $team->location()->first()) || ! ($location->lng) || ! ($location->lat)) {
            $this->error(Translate::get('Cannot find the team or location. Please refresh the page and try again!'));

            return;
        }

        $this->flyTo('team-map', $location->lng, $location->lat);
    }

    public function showPlaceDetail($placeId)
    {
        $this->dispatch('teamSelected', placeId: $placeId)->to('catalyst::components.teams.team-calendar-list');
    }

    public function getPlacesProperty()
    {
        $places = Location::query()
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $location) {
                return [
                    'id' => $location->model->id,
                    'name' => $location->model->name,
                    'description' => $this->getTeamDescriptionHTML($location),
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

    public function getTeamDescriptionHTML(Location $location)
    {
        $content = '';
        $content .= "<h3 class='h3 block'>{$location->model->name}</h2>";
        $content .= "<p>{$location->model->start_date->toFormattedDateString()}</p>";

        return $content;
    }

    public function render()
    {
        return view('catalyst::livewire.components.teams.map', [
            'places' => $this->places,
        ]);
    }
}
