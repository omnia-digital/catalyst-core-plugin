<?php

namespace OmniaDigital\CatalystCore\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use OmniaDigital\CatalystCore\Models\Bookmark;

trait HasBookmarks
{
    public function createBookmark($model, $modelId, $order = null, $userId = null, $teamId = null)
    {
        return $this->bookmarks()->create([
            'user_id' => $userId ?? $this->id,
            'team_id' => $teamId,
            'bookmarkable_type' => $model,
            'bookmarkable_id' => $modelId,
        ]);
    }

    /**
     * Get the bookmarks that User has created
     */
    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
