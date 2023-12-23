<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\LocationResource\Pages;

use OmniaDigital\CatalystCore\Filament\Admin\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
