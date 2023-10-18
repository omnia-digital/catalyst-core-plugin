<?php

namespace OmniaDigital\CatalystSocialPlugin\Livewire\Partials;

use Livewire\Component;
use OmniaDigital\CatalystSocialPlugin\Models\Post;

class PostActions extends Component
{
    public Post $post;

    public bool $show;

    public bool $showCommentButton = true;

    public bool $showLikeButton = true;

    public bool $showRepostButton = true;

    public bool $showShareButton = true;

    public bool $showBookmarkButton = false;

    public function mount(
        Post $post,
        $show = false,
        $showCommentButton = true,
        $showLikeButton = true,
        $showRepostButton = true,
        $showShareButton = true,
        $showBookmarkButton = false
    ) {
        $this->post = $post;
        $this->show = $show;
        $this->showCommentButton = $showCommentButton;
        $this->showBookmarkButton = $showBookmarkButton;
    }

    public function render()
    {
        return view('catalyst-social::livewire.partials.post-actions', [
            'show' => $this->show,
        ]);
    }
}
