<?php

namespace OmniaDigital\CatalystCore\Filament\Social\Pages;

use Filament\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\PostResource;
use OmniaDigital\CatalystCore\Models\Post;

class Show extends Page
{
//    use HasPageShield;
//    use WithGuestAccess;
    protected static string $view = 'catalyst::livewire.pages.posts.show';
    protected $listeners = ['postAdded' => '$refresh'];
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static bool $shouldRegisterNavigation = false;
//    protected static ?string $slug = 'posts/{record}';
    protected static ?string $title = 'Post';

    public ?Post $post = null;
    public $recentlyAddedComment;

    public function postAdded(Post $post)
    {
        $this->recentlyAddedComment = $post;
    }

    public function getViewData(): array
    {

//        dd($this->post);
//        $this->post = Post::withoutGlobalScope('parent')->findOrFail($this->post);
//
//        if ($this->post->type === PostType::ARTICLE) {
//            $this->redirectRoute('resources.show', $this->post->id);
//
//            return;
//        }
//
//        $this->post = $this->post->load('comments');
        return [
//            'post' => $this->post,
        ];
    }
}
