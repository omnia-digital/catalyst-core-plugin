<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Filament\Resources\UserScoreLevelResource\Pages;
use OmniaDigital\CatalystCore\Models\UserScoreLevel;

class UserScoreLevelResource extends Resource
{
    protected static ?string $model = UserScoreLevel::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('level')
                    ->integer()
                    ->minValue(0)
                    ->required(),
                TextInput::make('min_points')
                    ->label('Minimum Points')
                    ->integer()
                    ->minValue(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('level'),
                TextColumn::make('min_points')->label('Minimum Points'),
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
            'index' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\UserScoreLevelResource\Pages\ListUserScoreLevels::route('/'),
            'create' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\UserScoreLevelResource\Pages\CreateUserScoreLevel::route('/create'),
            'edit' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\UserScoreLevelResource\Pages\EditUserScoreLevel::route('/{record}/edit'),
        ];
    }
}
