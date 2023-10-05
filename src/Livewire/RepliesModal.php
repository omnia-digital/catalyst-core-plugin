<?php

namespace OmniaDigital\CatalystCore\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use OmniaDigital\CatalystCore\Actions\Posts\CreateNewPostAction;
use OmniaDigital\CatalystCore\Enums\PostType;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Notifications\NewCommentNotification;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystCore\Support\Livewire\WithPostEditor;
use Throwable;

class RepliesModal extends Component
{
    use WithGuestAccess;
    use WithPostEditor;

    public int $replyCount = 0;

    public Post $post;

    public bool $show;

    public ?PostType $type = null;

    public ?string $content = null;

    #[On('postAdded')]
    public function postAdded(): void
    {
        $this->replyCount = $this->post->comments()->count();
    }

    public function mount($post, $show = false, $type = null): void
    {
        $this->post = $post;
        $this->replyCount = $post->comments()->count();
        $this->show = $show;
        $this->type = $type;
    }

    /**
     * @throws Throwable
     */
    #[On('post-editor:submitted')]
    public function saveComment($editorId, $content, $images): void
    {
        $this->content = strip_tags($content);

        $this->validatePostEditor();

        $comment = DB::transaction(function () use ($content, $images) {
            $comment = (new CreateNewPostAction)
                ->asComment($this->post)
                ->type($this->type)
                ->execute($content);

            $comment->attachMedia($images ?? []);

            return $comment;
        });

        $this->post->user->notify(new NewCommentNotification($comment, auth()->user()));

        $this->emitPostSaved($editorId);
        $this->redirectRoute('social.posts.show', $this->post);
    }

    public function render()
    {
        return view('social::livewire.partials.replies-modal');
    }
}
