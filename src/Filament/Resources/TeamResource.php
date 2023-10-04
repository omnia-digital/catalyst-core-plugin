<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Models\Team;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DateTimePicker::make('start_date'),
            Forms\Components\Textarea::make('summary')
                ->maxLength(65535),
            Forms\Components\Textarea::make('content')
                ->maxLength(65535)
                ->required(),
            Forms\Components\TextInput::make('location')
                ->maxLength(255),
            Forms\Components\TextInput::make('rating'),
            Forms\Components\TextInput::make('languages')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([

            Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('handle')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('members_count')
                ->label('Members')
                ->counts('members')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('start_date')
                ->date(config('app.default_date_format')),
            Tables\Columns\TextColumn::make('created_at')
                ->date(config('app.default_date_format')),
        ])
            ->filters([//
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
            RelationManagers\TeamTypesRelationManager::class,
            RelationManagers\TeamTagsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'view' => Pages\ViewTeam::route('/{record}'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return Translate::get('Teams');
    }

    public static function getNavigationLabel(): string
    {
        return Translate::get('Teams');
    }

    //    public static function getEloquentQuery(): Builder
    //    {
    //        if (auth()->user()->is_admin) {
    //            return parent::getEloquentQuery();
    //        } else {
    //            return parent::getEloquentQuery()->whereIn('id', auth()->user()->ownedTeams->pluck('id'));
    //        }
    //    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()
            ->get()
            ->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getEloquentQuery()
            ->get()
            ->count() > 10 ? 'warning' : 'primary';
    }
}