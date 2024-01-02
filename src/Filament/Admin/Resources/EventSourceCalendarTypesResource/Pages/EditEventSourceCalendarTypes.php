<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarTypesResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarTypeResource;

class EditEventSourceCalendarTypes extends EditRecord
{
    protected static string $resource = EventSourceCalendarTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
