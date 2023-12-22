<?php

namespace OmniaDigital\CatalystCore\Providers\Filament;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use OmniaDigital\CatalystCore\Filament\Admin\Pages\Dashboard;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystForms\CatalystFormsPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: __DIR__ .'/../../Filament/Admin/Resources', for: 'OmniaDigital\\CatalystCore\\Filament\\Admin\\Resources')
            ->discoverPages(in: __DIR__ . '/../../Filament/Admin/Pages/', for: 'OmniaDigital\\CatalystCore\\Filament\\Admin\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                CatalystFormsPlugin::make()
            ])
            ->discoverWidgets(in: __DIR__.'/Filament/Admin/Widgets', for: 'OmniaDigital\\CatalystCore\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
//            ->viteTheme('css/omnia-digital/catalyst-core-plugin/catalyst-social-theme.css')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                \OmniaDigital\CatalystCore\Http\Middleware\Authenticate::class,
            ]);
    }
}
