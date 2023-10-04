<?php

namespace OmniaDigital\CatalystCore\Actions\Teams;

use OmniaDigital\CatalystCore\Models\Tag;

class GetTeamCategoriesAction
{
    public function execute(): array
    {
        return Tag::withType('team')->get()->all();
//        ->mapWithKeys(fn(Tag $tag) => [$tag->name => ucwords($tag->name)])
    }
}
