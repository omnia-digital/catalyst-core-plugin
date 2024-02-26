<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make('view'),
            Actions\DeleteAction::make('delete'),
        ];
    }
}
