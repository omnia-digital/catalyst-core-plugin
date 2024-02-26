<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource;

class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected static ?string $title = 'My Teams';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
