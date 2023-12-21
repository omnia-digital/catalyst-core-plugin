<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\EventResource\Pages;

use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
