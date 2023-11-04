<?php

namespace OmniaDigital\CatalystCore\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
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
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Filament\Social\Pages\Home;

class SocialPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('social')
            ->path('social')
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->renderHook('panels::head.end', function () {
                return view('catalyst::layouts.partials.header-styles');
            })
//            ->viteTheme('/public/css/omnia-digital/catalyst-core-plugin/catalyst-core-social-styles.css')
            ->discoverResources(
                in: __DIR__ . '/../../Filament/Social/Resources',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Social\\Resources'
            )
            ->discoverPages(
                in: __DIR__ . '/../../Filament/Social/Pages',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Social\\Pages'
            )
//            ->pages([
//                Home::class
//                //                Pages\Dashboard::class,
//            ])

            ->discoverWidgets(
                in: '../../Filament/Social/Widgets',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Social\\Widgets'
            )
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->navigationGroups([
//                NavigationGroup::make()
//                    ->label(Trans::get('Settings'))
//                    ->icon('heroicon-s-cog')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Billing'))
//                    ->icon('heroicon-o-credit-card')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Translate::get('People'))
//                    //                    ->icon('heroicon-s-users')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Teams'))
//                    ->icon('fas-users')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Forms'))
//                    ->icon('fab-wpforms')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Feeds'))
//                    ->icon('fad-rss')
//                    ->collapsed(),
//                NavigationGroup::make()
//                    ->label(Trans::get('Games'))
//                    ->icon('fad-gamepad-modern')
//                    ->collapsed(),
            ])
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
            ]);
//            ->authMiddleware([
//                Authenticate::class,
//            ]);
    }
}
