<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\Shield\PermissionResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\Shield\PermissionResource;

class ViewPermission extends ViewRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
