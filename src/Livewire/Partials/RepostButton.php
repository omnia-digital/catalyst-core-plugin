<?php

namespace OmniaDigital\CatalystCore\Livewire\Partials;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystCore\Actions\Posts\CreateNewPostAction;
use OmniaDigital\CatalystCore\Livewire\Partials\On;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Notifications\PostWasRepostedNotification;
use OmniaDigital\CatalystCore\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use Throwable;

class RepostButton extends Component
{
    use WithGuestAccess;
    use WithModal;
    use WithNotification;
    use WithPostEditor;

    public Post $model;

    public ?string $content = null;

    public function showRepostModal(): void
    {
        $this->openModal('repost-modal-' . $this->model->id);
    }

    /**
     * @throws Throwable
     */
    #[On('post-editor:submitted')]
    public function createRepost($data): void
    {
        $this->content = strip_tags($data['content']);

        $this->validatePostEditor();

        /** @var Post $repost */
        $repost = DB::transaction(function () use ($data) {
            $repost = (new CreateNewPostAction)
                ->asRepost($this->model)
                ->execute($data['content']);

            $repost->attachMedia($data['images'] ?? []);

            return $repost;
        });

        $this->model->user->notify(new PostWasRepostedNotification($repost, auth()->user()));

        $this->emitPostSaved($data['id']);
        $this->closeModal('repost-modal-' . $this->model->id);
        $this->redirectroute('catalyst-social.posts.show', $repost);
    }

    public function render()
    {
        return view('catalyst::livewire.partials.repost-button');
    }
}
