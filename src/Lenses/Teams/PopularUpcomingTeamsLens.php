<?php

namespace OmniaDigital\CatalystCore\Lenses\Teams;

use Illuminate\Database\Eloquent\Builder;
use OmniaDigital\CatalystCore\Lenses\BaseLens;

class PopularUpcomingTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query
            ->withCount(['likes'])
            ->whereBetween('start_date', [now()->addDays(7), now()])
            ->orderBy('likes_count', 'DESC');
    }
}
