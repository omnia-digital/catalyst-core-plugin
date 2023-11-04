<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\SubscriptionTypeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\SubscriptionTypeResource;

class ListSubscriptionTypes extends ListRecords
{
    protected static string $resource = SubscriptionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
