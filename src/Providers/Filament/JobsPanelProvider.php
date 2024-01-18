<?php

namespace OmniaDigital\CatalystCore\Providers\Filament;

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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class JobsPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('jobs')
            ->path('jobs')
            ->login()
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(
                in: __DIR__ . '/../../Filament/Jobs/Resources',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Jobs\\Resources'
            )
            ->discoverPages(
                in: __DIR__ . '/../../Filament/Jobs/Pages',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Jobs\\Pages'
            )
//            ->pages([
//                Home::class
//                //                Pages\Dashboard::class,
//            ])

            ->discoverWidgets(
                in: '../../Filament/Jobs/Widgets',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Jobs\\Widgets'
            )
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->topNavigation()
            ->sidebarCollapsibleOnDesktop()
            // Render Hooks for Jobs
            ->renderHook('panels::head.start', function () {
                return view('catalyst::layouts.partials.head-start');
            })
            ->renderHook('panels::head.end', function () {
                return view('catalyst::layouts.partials.head-end');
            })
            ->renderHook('panels::body.start', function () {
                return view('catalyst::layouts.partials.body-start');
            })
            ->renderHook('panels::user-menu.before', function () {
                return view('catalyst::components.team-switcher-menu',['team'=> Auth::user()->currentTeam]);
            })
            ->renderHook('panels::body.end', function () {
                return view('catalyst::layouts.partials.body-end');
            })
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
