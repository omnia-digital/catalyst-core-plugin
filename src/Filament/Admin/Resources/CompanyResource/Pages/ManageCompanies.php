<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\CompanyResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\CompanyResource;

class ManageCompanies extends ManageRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
