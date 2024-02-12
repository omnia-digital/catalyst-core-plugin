<?php

namespace OmniaDigital\CatalystCore\Filament\Core\Pages\Auth;


use Filament\Pages\SimplePage;
use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;

class Register extends SimplePage
{
    protected static string $view = 'catalyst::filament.core.pages.auth.register';

    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $title = 'Register';
    protected static bool $showTitle = true;
    protected static bool $showBackButton = true;

    public function getViewData(): array
    {
        return [];
    }
}
