<?php

namespace OmniaDigital\CatalystCore\Lenses\Teams;

use Illuminate\Database\Eloquent\Builder;
use OmniaDigital\CatalystCore\Lenses\BaseLens;

class UpcomingTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query->whereBetween('start_date', [now()->addDays(7), now()]);
    }
}
