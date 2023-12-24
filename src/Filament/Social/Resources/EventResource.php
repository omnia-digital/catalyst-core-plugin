<?php

namespace OmniaDigital\CatalystCore\Filament\Social\Resources;

use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use OmniaDigital\CatalystCore\Filament\Social\Resources\EventResource\Pages;
use OmniaDigital\CatalystCore\Models\Event;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'My Events';
    protected static ?int $navigationSort = 110;


    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('created_by', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('status')
                    ->content(fn(Event $record): string => new HtmlString(ucfirst($record->status)))
                    ->disabled()
                    ->columnSpanFull()
                    ->visibleOn(['edit']),
                Forms\Components\Tabs::make('Tabs')->tabs([
                    Tab::make('Details')->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('more_info_url'),
                        Forms\Components\TextInput::make('vendor_registration_url'),
                        Forms\Components\TextInput::make('buy_tickets_url'),
                        Forms\Components\TextInput::make('sponsor_registration_url'),
                        Forms\Components\TextInput::make('watch_live_url'),
                        Forms\Components\TextInput::make('watch_vod_url'),
                        Forms\Components\Toggle::make('is_public'),
                    ])->id('details')->icon('heroicon-o-information-circle'),
                    Tab::make('Date & Time')->schema([
                        Forms\Components\Select::make('timezone')
                            ->options(Event::availableTimezones())
                            ->required()->searchable(),
                        Forms\Components\Grid::make('Grid')->columns(2)->schema([
                            Forms\Components\DateTimePicker::make('starts_at'),
                            Forms\Components\DateTimePicker::make('ends_at'),
                        ]),
                        Forms\Components\Toggle::make('is_all_day'),
                        Forms\Components\Toggle::make('is_recurring'),
                    ])->id('date-time')->icon('heroicon-o-calendar'),
                ])->columnSpanFull()->persistTabInQueryString()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->formatStateUsing(fn(Event $record): string => ucfirst($record->status))
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'pending' => 'warning',
                        'approved' => 'success',
                        'denied' => 'danger',
                        'cancelled' => 'danger',
                    }),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Public')
                    ->boolean(),
                Tables\Columns\TextColumn::make('name')
                    ->description(fn(Event $record) => Str::limit($record->description, 50) ?? null)->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->description(fn(Event $record) => $record->location->address ?? null)
                    ->sortable(),
                Tables\Columns\TextColumn::make('timezoneLabel')
                    ->label('Timezone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable()
                    ->url(fn(Event $record): string => $record->url ?? '')
                    ->openUrlInNewTab()
                    ->limit(25),
                Tables\Columns\TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_all_day')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_recurring')
                    ->boolean(),
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
