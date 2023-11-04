<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\GameResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\GameResource;

class ManageGames extends ManageRecords
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
