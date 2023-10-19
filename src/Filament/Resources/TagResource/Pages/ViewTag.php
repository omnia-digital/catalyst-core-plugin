<?php

namespace OmniaDigital\CatalystCore\Filament\Resources\TagResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use OmniaDigital\CatalystCore\Filament\Resources\TagResource;

class ViewTag extends ViewRecord
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
