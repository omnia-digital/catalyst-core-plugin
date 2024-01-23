<?php

namespace OmniaDigital\CatalystCore\Filament\Social\Pages;

use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;
use OmniaDigital\CatalystCore\Filament\Pages\FeedSource;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Home extends BasePage
{
    use WithGuestAccess, WithMap, WithModal, WithNotification;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'catalyst::filament.pages.social.home';
    protected static bool $shouldRegisterNavigation = true;
    protected static bool $showBackButton = false;
    protected static bool $showTitle = false;

    public function getViewData(): array
    {
        return [
//            'places' => $this->places,
            'newsRssFeeds' => $this->getNewsRssFeeds(),
        ];
    }

    public function getNewsRssFeeds()
    {
        return collect();
    }
}
