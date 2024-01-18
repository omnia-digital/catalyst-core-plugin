<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources\EventResource\Pages;

use OmniaDigital\CatalystCore\Filament\Social\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
