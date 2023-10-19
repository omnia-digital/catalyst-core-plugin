<?php

namespace OmniaDigital\CatalystCore\Filament\Resources\Shield\RoleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Resources\Shield\RoleResource;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
