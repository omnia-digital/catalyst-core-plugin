<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Posts;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Trending extends Component
{
    use WithCachedRows;
    use WithPagination;

    public $type;

    public function mount($type = null)
    {
        if (! App::environment('production')) {
            $this->useCache = false;
        }

        if (! empty($type)) {
            $this->type = $type;
        }
    }

    public function getPostsQueryProperty()
    {
        return Post::getTrending($this->type);
    }

    public function getPostsProperty()
    {
        return $this->cache(function () {
            return $this->postsQuery->paginate(5);
        });
    }

    public function getProfilesQueryProperty()
    {
        return Profile::getTrending();
    }

    public function getProfilesProperty()
    {
        return $this->cache(function () {
            return $this->profilesQuery->paginate(5);
        });
    }

    public function render()
    {
        return view('social::livewire.pages.posts.trending', [
            'posts' => $this->posts,
            'profiles' => $this->profiles,
        ]);
    }
}
