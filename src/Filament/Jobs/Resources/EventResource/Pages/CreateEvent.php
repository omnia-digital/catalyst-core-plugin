<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources\EventResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use OmniaDigital\CatalystCore\Filament\Social\Resources\EventResource;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
    protected static ?string $title = 'Create Event';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['status'] = 'pending';

        return $data;
    }
}
