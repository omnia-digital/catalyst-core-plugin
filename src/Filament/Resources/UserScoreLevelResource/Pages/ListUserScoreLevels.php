<?php

namespace OmniaDigital\CatalystCore\Filament\Resources\UserScoreLevelResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Resources\UserScoreLevelResource;

class ListUserScoreLevels extends ListRecords
{
    protected static string $resource = UserScoreLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
