<?php

namespace OmniaDigital\CatalystCore\Actions\Teams;

use Illuminate\Support\Collection;
use OmniaDigital\CatalystCore\Models\Team;

class GetTrendingTeamsAction
{
    public function execute(int $limit = 5): array | Collection
    {
        return visits(Team::class)->top($limit);
    }
}
