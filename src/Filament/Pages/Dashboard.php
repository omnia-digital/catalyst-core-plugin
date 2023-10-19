<?php

namespace OmniaDigital\CatalystCore\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;
use Filament\Widgets\AccountWidget;
use OmniaDigital\CatalystCore\Filament\Resources\UserResource\Widgets\AdminUserStatsOverview;

class Dashboard extends BasePage
{
    public function getColumns(): int | array
    {
        return 4;
    }

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
//            AdminUserStatsOverview::class,
        ];
    }
}
