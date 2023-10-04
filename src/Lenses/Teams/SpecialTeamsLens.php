<?php

namespace OmniaDigital\CatalystCore\Lenses\Teams;

use Illuminate\Database\Eloquent\Builder;
use OmniaDigital\CatalystCore\Lenses\BaseLens;

class SpecialTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query->withAnyTags(['special']);
    }
}
