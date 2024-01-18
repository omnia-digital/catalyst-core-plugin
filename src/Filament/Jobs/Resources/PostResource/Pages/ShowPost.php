<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources\PostResource\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use OmniaDigital\CatalystCore\Enums\PostType;
use OmniaDigital\CatalystCore\Filament\Social\Resources\PostResource;
use OmniaDigital\CatalystCore\Models\Post;

class ShowPost extends Page
{
    use HasPageShield;
    use InteractsWithRecord;
//    use WithGuestAccess;

//    protected static string $resource = PostResource::class;
    protected static string $view = 'catalyst::livewire.pages.posts.show';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static bool $shouldRegisterNavigation = false;

    protected $listeners = ['postAdded' => '$refresh'];

    public ?Post $post = null;
    public ?Post $recentlyAddedComment = null;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->post = $this->getRecord();

        static::authorizeResourceAccess();
    }

    public function postAdded(Post $post)
    {
        $this->recentlyAddedComment = $post;
    }

    public function getViewData(): array
    {
//        $this->post = Post::withoutGlobalScope('parent')->findOrFail($this->post);
//
        if ($this->post->type === PostType::ARTICLE) {
            $this->redirectRoute('resources.show', $this->post->id);
        }
//
        $this->post = $this->post->load('comments');
        return [
        ];
    }

}
