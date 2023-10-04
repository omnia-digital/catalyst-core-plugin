<?php

namespace OmniaDigital\CatalystCore\Lenses\Teams;

use Illuminate\Database\Eloquent\Builder;
use OmniaDigital\CatalystCore\Lenses\BaseLens;

class PopularIndiesTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query
            ->withCount(['likes'])
            ->withAnyTags(['indie'])
            ->orderBy('likes_count', 'DESC');
    }
}
