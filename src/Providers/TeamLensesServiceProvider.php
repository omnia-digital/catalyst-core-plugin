<?php

namespace App\Providers;

use OmniaDigital\CatalystCore\Lenses\Teams\ByUserTagTeamsLens;
use OmniaDigital\CatalystCore\Lenses\Teams\IndiesTeamsLens;
use OmniaDigital\CatalystCore\Lenses\Teams\NewReleaseTeamsLens;
use OmniaDigital\CatalystCore\Lenses\Teams\PopularIndiesTeamsLens;
use OmniaDigital\CatalystCore\Lenses\Teams\PopularLocationTeamsLens;
use OmniaDigital\CatalystCore\Lenses\Teams\PopularUpcomingTeamsLens;
use OmniaDigital\CatalystCore\Lenses\Teams\SpecialTeamsLens;
use OmniaDigital\CatalystCore\Lenses\Teams\UpcomingTeamsLens;

class TeamLensesServiceProvider extends LensesServiceProvider
{
    public function register()
    {
        $this
            ->registerLens('new-releases', NewReleaseTeamsLens::class)
            ->registerLens('by-user-tags', ByUserTagTeamsLens::class)
            ->registerLens('popular-locations', PopularLocationTeamsLens::class)
            ->registerLens('specials', SpecialTeamsLens::class)
            ->registerLens('upcoming', UpcomingTeamsLens::class)
            ->registerLens('popular-upcoming', PopularUpcomingTeamsLens::class)
            ->registerLens('popular-indies', PopularIndiesTeamsLens::class)
            ->registerLens('indies', IndiesTeamsLens::class);
    }
}
