<?php

namespace OmniaDigital\CatalystCore\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Filament\Resources\UserScoreContributionResource\Pages;
use OmniaDigital\CatalystCore\Models\UserScoreContribution;

class UserScoreContributionResource extends Resource
{
    protected static ?string $model = UserScoreContribution::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('slug')
                ->required(),
            TextInput::make('points')
                ->integer()
                ->minValue(0)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name'),
            TextColumn::make('slug'),
            TextColumn::make('points'),
        ])
            ->filters([//
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
        return [//
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserScoreContributions::route('/'),
            'create' => Pages\CreateUserScoreContribution::route('/create'),
            'edit' => Pages\EditUserScoreContribution::route('/{record}/edit'),
        ];
    }
}
