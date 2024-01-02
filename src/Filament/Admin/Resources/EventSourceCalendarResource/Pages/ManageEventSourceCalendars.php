<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarResource;

class ManageEventSourceCalendars extends ManageRecords
{
    protected static string $resource = EventSourceCalendarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
