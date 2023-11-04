<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BasePage;
use Filament\Widgets\AccountWidget;

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
