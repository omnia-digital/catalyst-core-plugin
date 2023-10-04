<?php

namespace OmniaDigital\CatalystCore\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class DeletePostModal extends Component
{
    use AuthorizesRequests;
    use WithModal;
    use WithNotification;

    public Post $post;

    public ?string $content = null;

    public $confirmingDeletePost = false;

    protected $listeners = [
        'openDeletePostModal',
    ];

    public function openDeletePostModal(Post $post)
    {
        $this->post = $post;
        $this->confirmingDeletePost = true;
    }

    public function deletePost()
    {
        $this->authorize('delete', $this->post);

        if ($this->post) {
            $this->post->delete();
            $this->success('Post deleted successfully');

            $this->dispatch('postDeleted');
        }

        $this->confirmingDeletePost = false;
    }

    public function render()
    {
        return view('social::livewire.partials.delete-post-modal');
    }
}
