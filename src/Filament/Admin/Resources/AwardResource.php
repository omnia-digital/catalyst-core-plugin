<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Filament\Resources\AwardResource\Pages;
use OmniaDigital\CatalystCore\Models\Award;

class AwardResource extends Resource
{
    protected static ?string $model = Award::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('icon')
                    ->default('heroicon-o-academic-cap')
                    ->required(),
                Forms\Components\TextInput::make('bg_color')->nullable(),
                Forms\Components\TextInput::make('text_color')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('icon'),
                Tables\Columns\TextColumn::make('bg_color'),
                Tables\Columns\TextColumn::make('text_color'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make('edit'),
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
            'index' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\AwardResource\Pages\ListAwards::route('/'),
            'create' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\AwardResource\Pages\CreateAward::route('/create'),
            'edit' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\AwardResource\Pages\EditAward::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return Translate::get('Teams');
    }
}
