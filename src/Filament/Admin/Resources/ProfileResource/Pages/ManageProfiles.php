<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\ProfileResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\ProfileResource;

class ManageProfiles extends ManageRecords
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
