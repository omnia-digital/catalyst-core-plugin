<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\PostResource\Pages;

use OmniaDigital\CatalystCore\Filament\Admin\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
