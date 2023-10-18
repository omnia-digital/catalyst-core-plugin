<?php

namespace OmniaDigital\CatalystSocialPlugin\Livewire;

use Livewire\Component;
use OmniaDigital\CatalystSocialPlugin\Models\Post;

class DeletePostDropdownItem extends Component
{
    public Post $post;

    public bool $show;

    public ?string $content = null;

    public function mount($post, $show = false)
    {
        $this->post = $post;
        $this->show = $show;
    }

    /**
     * Confirm delete post.
     *
     * @return void
     */
    public function confirmDeletePost()
    {
        $this->dispatch('openDeletePostModal', postId: $this->post->id)->to('catalyst-social::delete-post-modal');
    }

    public function render()
    {
        return view('catalyst-social::livewire.partials.delete-post-dropdown-item');
    }
}
