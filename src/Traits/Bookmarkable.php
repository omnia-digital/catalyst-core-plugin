<?php

namespace OmniaDigital\CatalystSocialPlugin\Traits;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OmniaDigital\CatalystSocialPlugin\Models\Bookmark;

trait Bookmarkable
{
    public function isBookmarkedBy(User | Authenticatable $user = null): bool
    {
        is_null($user) && $user = auth()->user();
        $this->load('bookmarks');

        return $this->bookmarks->where('user_id', $user?->id)->isNotEmpty();
    }

    public function markAsBookmark(): self
    {
        $this->bookmarks()->create([
            'user_id' => auth()->id(),
            'team_id' => auth()->user()->currentTeam->id,
        ]);

        return $this;
    }

    /**
     * Get the bookmarks that all Users have created for this model
     */
    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function removeBookmark(): self
    {
        $this->bookmarks()->where('user_id', auth()->id())->delete();

        return $this;
    }
}
