<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarTypesResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarTypeResource;

class ManageEventSourceCalendarTypes extends ManageRecords
{
    protected static string $resource = EventSourceCalendarTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
