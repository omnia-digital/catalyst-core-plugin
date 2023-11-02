<?php

namespace OmniaDigital\CatalystCore\Policies;

use OmniaDigital\CatalystCore\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use OmniaDigital\CatalystCore\Models\Post;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @return void|bool
     */
    public function before(User $user)
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }

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
