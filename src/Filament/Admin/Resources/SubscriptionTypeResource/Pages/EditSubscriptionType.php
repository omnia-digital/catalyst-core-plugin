<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\SubscriptionTypeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\SubscriptionTypeResource;

class EditSubscriptionType extends EditRecord
{
    protected static string $resource = SubscriptionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
