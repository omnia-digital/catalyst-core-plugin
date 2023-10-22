<?php

namespace OmniaDigital\CatalystCore\Livewire;

use Livewire\Component;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystLocation\Models\Location;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Home extends Component
{
//    use WithGuestAccess;
//    use WithMap;
//    use WithModal;
//    use WithNotification;

    public $tabs = [];

    public function mount()
    {
        $this->tabs = [
            [
                'name' => 'Recent',
                'href' => '#',
                'current' => true,
            ],
            [
                'name' => 'Most Liked',
                'href' => '#',
                'current' => false,
            ],
            [
                'name' => 'Most Answers',
                'href' => '#',
                'current' => false,
            ],
        ];
    }

    public function getPlacesProperty()
    {
//        $places = Location::query()
//            ->hasCoordinates()
//            ->with('model')
//            ->get()
//            ->map(function (Location $location) {
//                return [
//                    'id' => $location->id,
//                    'name' => $location->model->name,
//                    'lat' => $location->lat,
//                    'lng' => $location->lng,
//                    'address' => $location->address,
//                    'address_line_2' => $location->address_line_2,
//                    'city' => $location->city,
//                    'state' => $location->state,
//                    'postal_code' => $location->postal_code,
//                    'country' => $location->country,
//                ];
//            });
//
//        return $places->all();
    }

    public function render()
    {
        dd('render');
        return view('catalyst-social::livewire.pages.home', [
            'places' => $this->places,
            'newsRssFeeds' => $this->getNewsRssFeeds(),
        ]);
    }

    public function getNewsRssFeeds()
    {
//        return Catalyst::isModuleEnabled('Feeds') ? FeedSource::first()->get() : collect();
    }
}
