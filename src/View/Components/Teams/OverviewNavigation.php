<?php

namespace App\View\Components\Teams;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use OmniaDigital\CatalystCore\Models\Team;

class OverviewNavigation extends Component
{
    public Team $team;

    public $pageView;

    public $nav = [
        'show' => 'Home',
        //        'members' => 'People',
        //        'resources' => 'Resources',
        //        'advice' => 'Advice',
        //        'jobs' => 'Jobs',
        //        'learn' => 'Courses',
        //        'awards' => 'Awards',
        //        'about' => 'About',
        //        'followers' => 'Followers'
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
        $this->pageView = array_slice(explode('.', Route::currentRouteName()), -1)[0];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.teams.overview-navigation');
    }
}
