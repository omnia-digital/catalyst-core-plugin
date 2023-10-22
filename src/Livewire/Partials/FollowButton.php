<?php

namespace OmniaDigital\CatalystCore\Livewire\Partials;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use OmniaDigital\CatalystCore\Notifications\NewFollowerNotification;

/**
 * @property User $authUser
 */
class FollowButton extends Component
{
    public Model $model;

    public function mount($model)
    {
        $this->model = $model;
    }

    public function follow()
    {
        if ($this->authUser->isFollowing($this->model)) {
            $this->authUser->unfollow($this->model);
        } else {
            $this->authUser->follow($this->model);

            $this->model->notify(new NewFollowerNotification($this->authUser));
        }
    }

    public function getAuthUserProperty()
    {
        return User::find(auth()->id());
    }

    public function render()
    {
        return view('catalyst::livewire.partials.follow-button');
    }
}
