<?php

namespace OmniaDigital\CatalystCore\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Filament\Resources\TagResource\Pages;
use OmniaDigital\CatalystCore\Models\Tag;

class TagResource extends Resource
{
    protected static ?string $label = 'Tags';

    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }

    public static function registerNavigationItems(): void
    {
        if (auth()->user()->hasRole('super_admin')) {
            parent::registerNavigationItems();
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->maxLength(255),
                Forms\Components\KeyValue::make('name')
                    ->keyLabel('Language Code')
                    ->valueLabel('Name')
                    ->required(),
                Forms\Components\KeyValue::make('slug')
                    ->keyLabel('Language Code')
                    ->valueLabel('Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('slug')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(config('app.default_datetime_format'))->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make('view'),
                Tables\Actions\EditAction::make('edit'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //            TaggableRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTag::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'view' => Pages\ViewTag::route('/{record}'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->get()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getEloquentQuery()->get()->count() > 10 ? 'warning' : 'primary';
    }
}
