<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\Shield\RoleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\Shield\RoleResource;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
