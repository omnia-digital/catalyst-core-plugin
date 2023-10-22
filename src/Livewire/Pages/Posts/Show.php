<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Posts;

use Livewire\Component;
use OmniaDigital\CatalystCore\Enums\PostType;
use OmniaDigital\CatalystCore\Models\Post;

class Show extends Component
{
    public $post;

    public $recentlyAddedComment;

    protected $listeners = ['postAdded' => '$refresh'];

    public function postAdded(Post $post)
    {
        $this->recentlyAddedComment = $post;
    }

    public function mount($post)
    {
        $this->post = Post::withoutGlobalScope('parent')->findOrFail($post);

        if ($this->post->type === PostType::ARTICLE) {
            $this->redirectRoute('resources.show', $this->post->id);

            return;
        }

        $this->post = $this->post->load('comments');
    }

    public function render()
    {
        return view('catalyst::livewire.pages.posts.show');
    }
}
