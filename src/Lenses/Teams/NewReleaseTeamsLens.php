<?php

namespace OmniaDigital\CatalystCore\Lenses\Teams;

use Illuminate\Database\Eloquent\Builder;
use OmniaDigital\CatalystCore\Lenses\BaseLens;

class NewReleaseTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query->whereBetween('start_date', [now(), now()->addDays(7)]);
    }
}
