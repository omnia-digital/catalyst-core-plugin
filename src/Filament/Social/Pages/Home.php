<?php

namespace OmniaDigital\CatalystCore\Filament\Social\Pages;

use Filament\Pages\Page;
use OmniaDigital\CatalystCore\Catalyst;
use OmniaDigital\CatalystCore\Filament\Pages\FeedSource;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Home extends Page
{
    use WithGuestAccess, WithMap, WithModal, WithNotification;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'catalyst::filament.pages.social.home';
    public function getNewsRssFeeds()
    {
        return collect();
    }

    public function getViewData(): array
    {
        return [
//            'places' => $this->places,
            'newsRssFeeds' => $this->getNewsRssFeeds(),
        ];
    }
}
