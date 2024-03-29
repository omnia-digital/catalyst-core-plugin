<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Modules\Feeds\Enums\FeedSourceType;
use Modules\Feeds\Models\FeedSource;
use OmniaDigital\CatalystCore\Filament\Resources\FeedSourceResource\Pages;

class FeedSourceResource extends Resource
{
    protected static ?string $model = FeedSource::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    protected static ?string $navigationGroup = 'Feeds';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),

                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->rules(['url']),

                Forms\Components\Select::make('type')
                    ->options(FeedSourceType::options())
                    ->required()
                    ->rules([Rule::in(array_keys(FeedSourceType::options()))]),

                Forms\Components\SpatieMediaLibraryFileUpload::make('default_feed_image'),
                Forms\Components\SpatieMediaLibraryFileUpload::make('default_item_image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('url')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\SelectColumn::make('type')
                    ->options(FeedSourceType::options())
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\FeedSourceResource\Pages\ListFeedSources::route('/'),
            'create' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\FeedSourceResource\Pages\CreateFeedSource::route('/create'),
            'edit' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\FeedSourceResource\Pages\EditFeedSource::route('/{record}/edit'),
        ];
    }
}
