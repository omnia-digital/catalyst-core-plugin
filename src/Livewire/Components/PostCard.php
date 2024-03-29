<?php

namespace OmniaDigital\CatalystCore\Livewire\Components;

use Livewire\Component;
use OmniaDigital\CatalystCore\Catalyst;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use function view;

class PostCard extends Component
{
    use WithGuestAccess;
    use WithNotification;

    public Post $post;

    public $optionsMenuOpen = false;

    public $clickable;

    public $showPostActions = true;

    public function mount(Post $post, $clickable = true, $showPostActions = true)
    {
        $this->post = $post;
        $this->clickable = $clickable;
        $this->showPostActions = $showPostActions;
        $this->loadRelations();
    }

    public function loadRelations()
    {
        $this->post->load(['user', 'team', 'media', 'repostOriginal', 'tags']);
    }

    public function getAuthorProperty()
    {
        return $this->post->user;
    }

    public function showPost()
    {
        if ($this->clickable) {
            return $this->redirectroute('catalyst-social.posts.show', $this->post);
        }
    }

    public function showProfile($handle = null, $team = false)
    {
        if ($team) {
            return $this->redirectroute('catalyst-social.teams.show', $handle);
        }
        if ($handle) {
            return $this->redirectroute('catalyst-social.profile.show', $handle);
        }

        return $this->redirectroute('catalyst-social.profile.show', $this->author->handle);
    }

    public function toggleBookmark()
    {
        if (Catalyst::isAllowingGuestAccess() && ! auth()->check()) {
            $this->showAuthenticationModal(route('catalyst-social.posts.show', $this->post));

            return;
        }

        if ($this->post->isBookmarkedBy()) {
            $this->post->removeBookmark();
            $this->post->refresh();

            $this->success('Remove bookmark successfully!');

            return;
        }

        $this->post->markAsBookmark();
        $this->post->refresh();

        $this->success('Bookmark the resource successfully!');
    }

    /**
     * Confirm delete post.
     *
     * @return void
     */
    public function confirmDeletePost()
    {
        $this->dispatch('openDeletePostModal', postId: $this->post->id)->to('catalyst::delete-post-modal');
    }

    public function render()
    {
        return view('catalyst::livewire.components.post-card');
    }
}
