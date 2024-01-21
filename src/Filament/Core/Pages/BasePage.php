<?php

namespace OmniaDigital\CatalystCore\Filament\Core\Pages;

use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class BasePage extends Page
{
    use InteractsWithRecord;

//    protected static string $layout = 'catalyst::vendor.filament.layout.index';

    protected static bool $shouldRegisterNavigation = false;
    protected static bool $showTitle = true;
    protected static bool $showBackButton = true;

    public function getHeader(): ?View
    {
        return view('catalyst::filament.core.partials.page-header',
            [
                'title' => self::getTitle(),
                'icon' => self::getNavigationIcon() ?? null,
                'showTitle' => self::getShowTitle(),
                'showBackButton' => self::getShowBackButton()
            ]);
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
//        return MaxWidth::Full;
    }

    public function getShowTitle(): bool
    {
        return static::$showTitle ?? true;
    }

    public function getShowBackButton(): bool
    {
        return static::$showBackButton ?? true;
    }

//    protected function getHeaderActions(): array
//    {
//        return [
//            Action::make('edit')
//                ->url(route('filament.jobs.home', ['job' => $this->job])),
//            Action::make('delete')
//                ->requiresConfirmation()
//                ->action(fn () => $this->job->delete()),
//        ];
//    }
}
