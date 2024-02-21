<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarResource\Pages;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarResource;

class EditEventSourceCalendar extends EditRecord
{
    protected static string $resource = EventSourceCalendarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
