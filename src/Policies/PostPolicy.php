<?php

namespace OmniaDigital\CatalystCore\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Traits\Policies\HasDefaultPolicy;

class PostPolicy
{
    use HandlesAuthorization;
    use HasDefaultPolicy;

    /**
     * @return true
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->is($post->user);
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->is($post->user);
    }
}
