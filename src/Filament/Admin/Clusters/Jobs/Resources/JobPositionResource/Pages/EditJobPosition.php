<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Clusters\Jobs\Resources\JobPositionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Clusters\Jobs\Resources\JobPositionResource;

class EditJobPosition extends EditRecord
{
    protected static string $resource = JobPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
