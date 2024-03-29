<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\UserScoreContributionResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\UserScoreContributionResource;

class EditUserScoreContribution extends EditRecord
{
    protected static string $resource = UserScoreContributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
