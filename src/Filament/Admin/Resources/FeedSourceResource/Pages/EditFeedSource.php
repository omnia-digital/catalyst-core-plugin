<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\FeedSourceResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\FeedSourceResource;

class EditFeedSource extends EditRecord
{
    protected static string $resource = FeedSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
