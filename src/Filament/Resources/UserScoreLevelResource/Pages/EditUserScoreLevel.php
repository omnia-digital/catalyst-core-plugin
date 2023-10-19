<?php

namespace OmniaDigital\CatalystCore\Filament\Resources\UserScoreLevelResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Resources\UserScoreLevelResource;

class EditUserScoreLevel extends EditRecord
{
    protected static string $resource = UserScoreLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
