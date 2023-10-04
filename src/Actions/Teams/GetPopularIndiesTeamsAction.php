<?php

namespace OmniaDigital\CatalystCore\Actions\Teams;

use Illuminate\Database\Eloquent\Collection;
use OmniaDigital\CatalystCore\Models\Team;

class GetPopularIndiesTeamsAction
{
    public function execute(int $limit = 5): Collection
    {
        return Team::query()
            ->limit($limit)
            ->withCount(['likes', 'users as members'])
            ->withAnyTags(['indie'])
            ->orderBy('likes_count', 'DESC')
            ->get();
    }
}
