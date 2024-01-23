<?php

namespace OmniaDigital\CatalystCore\Providers\Filament;

use App\Models\Team;
use App\Models\User;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
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
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Filament\Social\Pages\Home;
use Spatie\LaravelSettings\Settings;

class SocialPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('social')
            ->path('social')
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
                in: __DIR__ . '/../../Filament/Social/Resources',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Social\\Resources'
            )
            ->discoverPages(
                in: __DIR__ . '/../../Filament/Social/Pages',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Social\\Pages'
            )
            ->discoverWidgets(
                in: '../../Filament/Social/Widgets',
                for: 'OmniaDigital\\CatalystCore\\Filament\\Social\\Widgets'
            )
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
//            ->topNavigation()
//            ->sidebarCollapsibleOnDesktop()
            // Render Hooks for Social
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
//            ->navigationItems([
//                NavigationItem::make('Discover')
//                    ->url('discover')
//                    ->icon('fas-telescope'),
//                NavigationItem::make('Resources')
//                    ->url('/resources')
//                ->icon('fas-users')
//            ])
//            ->userMenuItems([
//                MenuItem::make()->label('Settings'),
//                'profile' => MenuItem::make()->label('Edit profile'),
//
//            ])
//            ->tenantMenuItems([
//                MenuItem::make()
//                    ->label('Settings')
//                    ->url(fn (): string => Settings::getUrl())
//                    ->icon('heroicon-m-cog-8-tooth'),
//                // ...
//            ])
//            ->navigationGroups([
//                NavigationGroup::make()
//                    ->label('Settings')
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
//            ])
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
