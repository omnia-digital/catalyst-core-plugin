<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;

class AdminUserStatsOverview extends BaseWidget
{
    //    protected int | string | array $columnSpan = '4';

    public static function canView(): bool
    {
        return auth()?->user()?->hasRole('super_admin') ?? false;
    }

    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::count()),
            Card::make('Users in Teams', $this->getUsersWithTeams()),
        ];
    }

    private function getUsersWithTeams(): int
    {
        return User::query()->whereHas('teams')->count();
    }
}
