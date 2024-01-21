<?php

namespace OmniaDigital\CatalystCore\Filament\Core\Pages;

use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class BasePage extends Page
{
    use InteractsWithRecord;

    protected static bool $shouldRegisterNavigation = false;

    public function getHeader(): ?View
    {
        return view('catalyst::filament.core.partials.page-header',
            ['title' => self::getTitle(), 'icon' => self::getNavigationIcon()]);
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
//        return MaxWidth::Full;
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
