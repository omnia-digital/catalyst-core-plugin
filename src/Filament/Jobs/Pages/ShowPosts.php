<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use OmniaDigital\CatalystCore\Models\Post;

class ShowPosts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'catalyst::livewire.pages.posts.show';
    protected static bool $shouldRegisterNavigation = false;

//    protected static ?string $slug = 'posts/{record}';

    public Post $post;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Action::make('edit')
//                ->url(route('posts.edit', ['post' => $this->post])),
//            Action::make('delete')
//                ->requiresConfirmation()
//                ->action(fn () => $this->post->delete()),
//        ];
//    }
}
