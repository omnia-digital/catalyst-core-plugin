<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Filament\Resources\SubscriptionTypeResource\Pages;
use OmniaDigital\CatalystCore\Models\SubscriptionType;

class SubscriptionTypeResource extends Resource
{
    protected static ?string $model = SubscriptionType::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Billing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->minValue('500')
                    ->label('Amount (in cents)')
                    ->helperText('Please write the amount in cents. For example: For $55.25, write 5525.')
                    ->mask(
                        fn (Forms\Components\TextInput\Mask $mask) => $mask
                            ->numeric()
                            ->integer()
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('amount')->label('Amount (in cents)'),
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
            'index' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\SubscriptionTypeResource\Pages\ListSubscriptionTypes::route('/'),
            'create' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\SubscriptionTypeResource\Pages\CreateSubscriptionType::route('/create'),
            'edit' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\SubscriptionTypeResource\Pages\EditSubscriptionType::route('/{record}/edit'),
        ];
    }
}
