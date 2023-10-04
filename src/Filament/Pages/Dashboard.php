<?php

namespace App\Filament\Pages;

use App\Filament\Resources\UserResource\Widgets\AdminUserStatsOverview;
use Filament\Pages\Dashboard as BasePage;
use Filament\Widgets\AccountWidget;

class Dashboard extends BasePage
{
    public function getColumns(): int|array
    {
        return 4;
    }

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            AdminUserStatsOverview::class,
        ];
    }
}
