<?php

namespace OmniaDigital\CatalystCore\Traits\Tag;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTeamTags
{
    public function tags(): MorphToMany
    {
        return $this->teamTags();
    }

    public function teamTags()
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable')
            ->where('type', 'team')
            ->ordered();
    }
}
