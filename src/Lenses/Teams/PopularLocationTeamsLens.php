<?php

namespace OmniaDigital\CatalystCore\Lenses\Teams;

use Illuminate\Database\Eloquent\Builder;
use OmniaDigital\CatalystCore\Lenses\BaseLens;

class PopularLocationTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query;
    }
}
