<?php

namespace OmniaDigital\CatalystCore\Filament\Resources\FormTypeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Resources\FormTypeResource;

class ListFormsType extends ListRecords
{
    protected static string $resource = FormTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
