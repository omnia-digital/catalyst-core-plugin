<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Partials;

use Livewire\Component;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Notifications\PostWasBookmarkedNotification;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;

class BookmarkButton extends Component
{
    use WithGuestAccess;

    public Post $model;

    public bool $show = false;

    public function toggleBookmark()
    {
        if (Catalyst::isAllowingGuestAccess() && ! auth()->check()) {
            $this->showAuthenticationModal(route('social.posts.show', $this->model));

            return;
        }

        if ($this->model->isBookmarkedBy()) {
            $this->model->removeBookmark();
        } else {
            $this->model->markAsBookmark();

            $this->model->user->notify(new PostWasBookmarkedNotification($this->model, auth()->user()));
        }

        $this->model->refresh();
        $this->model->loadCount('bookmarks');
    }

    public function render()
    {
        return view('social::livewire.partials.bookmark-button');
    }
}
