<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\CompanyResource\Pages\CreateCompany;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\CompanyResource\Pages\EditCompany;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\CompanyResource\Pages\ManageCompanies;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarResource\Pages\CreateEventSourceCalendars;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarResource\Pages\EditEventSourceCalendar;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarResource\Pages\ManageEventSourceCalendars;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventSourceCalendarResource\Pages\ManageEventSourceCalendarTypes;
use RalphJSmit\Filament\Components\Forms\Timestamps;

class EventSourceCalendarResource extends Resource
{
    protected static ?string $model = \OmniaDigital\CatalystCore\Models\EventSourceCalendar::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Calendar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name'),
            Forms\Components\Textarea::make('description'),
            Forms\Components\TextInput::make('slug'),
            Forms\Components\TextInput::make('ext_calendar_id'),
            Forms\Components\TextInput::make('calendar_url')->url(),
            Forms\Components\Toggle::make('is_external'),
            Forms\Components\Toggle::make('is_public'),
            Forms\Components\Select::make('event_source_calendar_type_id')
                ->relationship(name: 'eventSourceCalendarType', titleAttribute: 'name'),
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
            Tables\Columns\TextColumn::make('event_source_calendar_type_id')
                ->sortable()
                ->formatStateUsing(fn(Model $record) => "{$record->load('eventSourceCalendarType')->eventSourceCalendarType?->name}")
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
            'index' => ManageEventSourceCalendars::route('/'),
            'create' => CreateEventSourceCalendars::route('/create'),
            'edit' => EditEventSourceCalendar::route('/edit/{record}'),
        ];
    }
}
