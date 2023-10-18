<?php

namespace OmniaDigital\CatalystSocialPlugin\Actions\Posts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Traits\Conditionable;
use OmniaDigital\CatalystSocialPlugin\Enums\PostType;

class CreateNewPostAction
{
    use Conditionable;

    protected User | Authenticatable | null $user = null;

    protected ?Model $postable = null;

    protected ?Model $repost = null;

    protected ?PostType $type = null;

    protected ?Team $team = null;

    public function asComment(Model $parent): self
    {
        $this->postable = $parent;

        return $this;
    }

    public function asRepost(Model $repost): self
    {
        $this->repost = $repost;

        return $this;
    }

    public function type(?PostType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function execute(string $content, array $options = []): Post
    {
        $user = $this->user ?? auth()->user();

        $post = $user->posts()->create([
            'type' => $this->type,
            'body' => Mention::processMentionContent($content),
            'team_id' => $options['team_id'] ?? null,
            'title' => $options['title'] ?? null,
            'url' => $options['url'] ?? null,
            'published_at' => $options['published_at'] ?? null,
            'postable_id' => $this->postable?->id ?? $options['postable_id'] ?? null,
            'postable_type' => $this->postable ? get_class($this->postable) : ($options['postable_type'] ?? null),
            'repost_original_id' => $this->repost?->id,
        ]);

        $hashtags = Tag::parseHashTagsFromString($content);
        $tags = Tag::findOrCreateTags($hashtags, 'post');
        $post->attachTags($tags, 'post');

        [$userMentions, $teamMentions] = Mention::getAllMentions($content);

        Mention::createManyFromHandles($userMentions, User::class, $post);
        Mention::createManyFromHandles($teamMentions, Team::class, $post);

        return $post;
    }

    public function user(User | Authenticatable $user): self
    {
        $this->user = $user;

        return $this;
    }
}
