<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources\EventResource\Pages;

use Illuminate\Contracts\Support\Htmlable;
use OmniaDigital\CatalystCore\Filament\Social\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit Event: ' .$this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
