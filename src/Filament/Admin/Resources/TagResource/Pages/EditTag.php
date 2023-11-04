<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\TagResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\TagResource;

class EditTag extends EditRecord
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make('view'),
            Actions\DeleteAction::make('delete'),
        ];
    }
}
