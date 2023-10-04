<?php

namespace OmniaDigital\CatalystCore\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OmniaDigital\CatalystCore\Actions\Posts\CreateNewPostAction;
use OmniaDigital\CatalystCore\Models\Post;

trait Postable
{
    /**
     * Alias for posts()
     */
    public function comments(): MorphMany
    {
        return $this->posts();
    }

    /**
     * Get the posts for the current model
     */
    public function posts(): MorphMany
    {
        // @NOTE - we have to remove the 'parent' globalscope in order to retrieve comments
        return $this->morphMany(Post::class, 'postable')
            ->withoutGlobalScope('parent');
    }

    //** Aliases **//

    /**
     * Alias for createPost()
     */
    public function createComment($data, $userId): Model | Post
    {
        return $this->createPost($data, $userId);
    }

    /**
     * Handles creating the post for the current model
     */
    public function createPost($data, $userId): Model | Post
    {
        return
            (new CreateNewPostAction)
                ->user($userId)
                ->execute($data['body'], [
                    'title' => $data['title'] ?? null,
                    'url' => $data['url'] ?? null,
                    'image' => $data['image'] ?? null,
                ]);
    }
}
