<?php

namespace OmniaDigital\CatalystSocialPlugin\Livewire\Components;

use OmniaDigital\CatalystSocialPlugin\Models\Post;
use function view;

class PostCardDynamic extends PostCard
{
    public function mount(Post $post, $clickable = true, $showPostActions = true)
    {
        $this->post = $post;
        $this->clickable = $clickable;
        $this->showPostActions = $showPostActions;
    }

    public function render()
    {
        return view('catalyst-social::livewire.components.post-card-dynamic');
    }
}
