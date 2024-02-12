<?php

namespace OmniaDigital\CatalystCore\Filament\Core\Pages\Auth;


use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;

class Login extends BasePage
{
    protected static string $view = 'catalyst::filament.core.pages.auth.login';

    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $title = 'Login';
    protected static bool $showTitle = true;
    protected static bool $showBackButton = true;

    public function getViewData(): array
    {
        return [];
    }
}
