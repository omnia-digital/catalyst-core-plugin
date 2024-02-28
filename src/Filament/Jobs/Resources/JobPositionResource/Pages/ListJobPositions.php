<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources\JobPositionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Jobs\Resources\JobPositionResource;

class ListJobPositions extends ListRecords
{
    protected static string $resource = JobPositionResource::class;
    protected static ?string $title = 'My Jobs';
    protected static ?string $breadcrumb = 'My Jobs';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
