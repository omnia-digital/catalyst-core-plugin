<?php

namespace OmniaDigital\CatalystCore\Actions\Teams;

use Illuminate\Database\Eloquent\Collection;
use OmniaDigital\CatalystCore\Models\Team;

class GetFeaturedTeamsAction
{
    public function execute(int $limit = 5): Collection
    {
        return Team::query()
            ->limit($limit)
            ->withCount('users as members')
            ->withAnyTags(['featured', 'recommended'], 'team')
            ->get();
    }
}
