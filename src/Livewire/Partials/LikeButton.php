<?php

namespace OmniaDigital\CatalystCore\Livewire\Partials;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Notifications\PostWasLikedNotification;

class LikeButton extends Component
{
    use WithGuestAccess;

    public Model $model;

    public $show;

    public $hideCount;

    public $withDislikes;

    public $btnStyles;

    public function mount($model, $show = false, $hideCount = false, $withDislikes = false, $btnStyles = '')
    {
        $this->model = $model;
        $this->show = $show;
        $this->hideCount = $hideCount;
        $this->withDislikes = $withDislikes;
        $this->btnStyles = $btnStyles;
    }

    public function like()
    {
        if (Catalyst::isAllowingGuestAccess() && ! auth()->check()) {
            $this->showAuthenticationModal(route('social.posts.show', $this->model));

            return;
        }

        $this->model->like();

        if ((get_class($this->model) == Post::class) && $this->model->refresh()->is_liked) {
            $this->model->user->notify(new PostWasLikedNotification($this->model, auth()->user()));
        }
    }

    public function dislike()
    {
        $this->model->dislike();
    }

    public function render()
    {
        return view('catalyst-social::livewire.partials.like-button');
    }
}
