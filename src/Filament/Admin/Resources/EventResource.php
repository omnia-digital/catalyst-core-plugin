<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventResource\Pages;
use OmniaDigital\CatalystCore\Models\Event;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFormFields());
    }

    public static function getFormFields()
    {
        return [
            Forms\Components\Select::make('created_by')
                ->relationship(name: 'createdBy')
                ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name}")
//                    ->searchable()
                ->required(),
            Forms\Components\Select::make('team_id')
                ->relationship(name: 'team', titleAttribute: 'name')->searchable(),
//                Forms\Components\TextInput::make('location_id'),
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\Toggle::make('is_public'),
            Forms\Components\Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),
            Forms\Components\Select::make('timezone')
                ->options(\DateTimeZone::listIdentifiers())
                ->required(),
            Forms\Components\TextInput::make('more_info_url'),
            Forms\Components\TextInput::make('vendor_registration_url'),
            Forms\Components\TextInput::make('buy_tickets_url'),
            Forms\Components\TextInput::make('sponsor_registration_url'),
            Forms\Components\TextInput::make('watch_live_url'),
            Forms\Components\TextInput::make('watch_vod_url'),
            Forms\Components\DateTimePicker::make('starts_at'),
            Forms\Components\DateTimePicker::make('ends_at'),
            Forms\Components\Toggle::make('is_all_day')
                ->required(),
            Forms\Components\Toggle::make('is_recurring')
                ->required(),
            Forms\Components\Toggle::make('is_published')
                ->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'pending' => 'Pending Approval',
                    'approved' => 'Approved',
                    'denied' => 'Denied',
                    'cancelled' => 'Cancelled',
                ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'pending' => 'Pending Approval',
                        'approved' => 'Approved',
                        'denied' => 'Denied',
                        'cancelled' => 'Cancelled',
                    ])->disablePlaceholderSelection(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->sortable()
                    ->formatStateUsing(fn(Model $record) => "{$record->createdBy->name}")
                    ->searchable(),
                Tables\Columns\TextColumn::make('team.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->description(fn(Event $record) => $record->location->address ?? null)
                    ->sortable(),
                Tables\Columns\TextColumn::make('timezoneLabel')
                    ->label('Timezone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('url')
                    ->url(fn(Event $record): string => $record->url ?? '')
                    ->openUrlInNewTab()
                    ->limit(25),
                Tables\Columns\TextColumn::make('starts_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_all_day'),
                Tables\Columns\ToggleColumn::make('is_recurring'),
                Tables\Columns\ToggleColumn::make('is_published'),
                Tables\Columns\ToggleColumn::make('is_public'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
