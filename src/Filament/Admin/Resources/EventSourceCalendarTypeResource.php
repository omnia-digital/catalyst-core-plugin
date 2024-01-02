<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarTypesResource\Pages\CreateEventSourceCalendarTypes;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarTypesResource\Pages\EditEventSourceCalendarTypes;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarTypesResource\Pages\ManageEventSourceCalendarTypes;
use RalphJSmit\Filament\Components\Forms\Timestamps;

class EventSourceCalendarTypeResource extends Resource
{
    protected static ?string $model = \OmniaDigital\CatalystCore\Models\EventSourceCalendarType::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Calendar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name'),
            Forms\Components\TextInput::make('slug'),
            ...Timestamps::make(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')
                ->sortable()
                ->searchable(),
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('slug')
                ->sortable()
                ->searchable(),
            TextColumn::make('created_at')
                ->sortable()
                ->searchable(),
            TextColumn::make('updated_at')
                ->sortable()
                ->searchable(),
            TextColumn::make('deleted_at')
                ->sortable()
                ->searchable(),
        ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageEventSourceCalendarTypes::route('/'),
            'create' => CreateEventSourceCalendarTypes::route('/create'),
            'edit' => EditEventSourceCalendarTypes::route('/edit/{record}'),
        ];
    }
}
