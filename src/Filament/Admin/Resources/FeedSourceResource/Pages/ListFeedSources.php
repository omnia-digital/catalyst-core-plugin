<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources\FeedSourceResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\FeedSourceResource;

class ListFeedSources extends ListRecords
{
    protected static string $resource = FeedSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
