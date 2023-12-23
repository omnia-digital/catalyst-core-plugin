<?php

namespace OmniaDigital\CatalystCore\Filament\Social\Resources\EventResource\Pages;

use OmniaDigital\CatalystCore\Filament\Social\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['status'] = 'pending';

        return $data;
    }
}
