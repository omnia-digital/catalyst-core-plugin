<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\UserScoreContributionResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\UserScoreContributionResource;

class ListUserScoreContributions extends ListRecords
{
    protected static string $resource = UserScoreContributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
