<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Clusters\Jobs\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Filament\Admin\Clusters\Jobs;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;

class JobPositionResource extends Resource
{
    protected static ?string $model = JobPosition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $cluster = Jobs::class;
    protected static ?string $navigationLabel = 'Home';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                        Tables\Columns\TextColumn::make('team')
                            ->sortable()
                            ->searchable()
                            ->label(function (JobPosition $model) {
                                return $model->team?->name;
                            }),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                        Tables\Columns\TextColumn::make('team')
                            ->sortable()
                            ->searchable()
                            ->label(function (JobPosition $model) {
                                return $model->team?->name;
                            }),
                    ])->alignment(Alignment::End)
                        ->visibleFrom('md'),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('user')
                            ->sortable()
                            ->searchable()
                            ->label(function (JobPosition $model) {
                                return $model->user?->name;
                            }),
                        Tables\Columns\TextColumn::make('location')
                            ->sortable()
                            ->searchable()
                            ->label(function (JobPosition $model) {
                                return $model->location?->name;
                            }),
                        Tables\Columns\TextColumn::make('apply_type'),
                        Tables\Columns\TextColumn::make('created_at')->date()->sortable(),
                    ]),
                    IconColumn::make('is_active')
                        ->boolean()->sortable(),
                ]),
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
            'index' => Jobs\Resources\JobPositionResource\Pages\ListJobPositions::route('/'),
            'create' => Jobs\Resources\JobPositionResource\Pages\CreateJobPosition::route('/create'),
            'edit' => Jobs\Resources\JobPositionResource\Pages\EditJobPosition::route('/{record}/edit'),
        ];
    }
}
