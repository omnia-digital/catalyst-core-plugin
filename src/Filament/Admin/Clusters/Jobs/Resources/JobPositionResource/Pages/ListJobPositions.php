<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Clusters\Jobs\Resources\JobPositionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Clusters\Jobs\Resources\JobPositionResource;

class ListJobPositions extends ListRecords
{
    protected static string $resource = JobPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
