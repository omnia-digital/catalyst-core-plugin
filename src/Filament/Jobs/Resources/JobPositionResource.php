<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Filament\Jobs\Resources\JobPositionResource\Pages\CreateJobPosition;
use OmniaDigital\CatalystCore\Filament\Jobs\Resources\JobPositionResource\Pages\EditJobPosition;
use OmniaDigital\CatalystCore\Filament\Jobs\Resources\JobPositionResource\Pages\ListJobPositions;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;

class JobPositionResource extends Resource
{
    protected static ?string $model = JobPosition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    //    protected static ?string $navigationLabel = 'My Jobs';
    protected static ?string $breadcrumb = 'Jobs';

    public static function canAccess(): bool
    {
        return Filament::auth()->user()->isAdmin;
    }

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
                        Tables\Columns\TextColumn::make('team.name')
                            ->sortable()
                            ->searchable()
                            ->label(function (JobPosition $model) {
                                return $model->team?->name;
                            }),
                        Tables\Columns\TextColumn::make('location')
                            ->sortable()
                            ->searchable()
                            ->label(function (JobPosition $model) {
                                return $model->location?->name;
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
                        Tables\Columns\TextColumn::make('created_at')->label('Posted')->date()->sortable(),
                    ]),
                    IconColumn::make('is_active')
                        ->boolean()->sortable(),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
            ])
            ->recordUrl(
                fn (Model $record): string => route('filament.jobs.resources.job-positions.edit', ['record' => $record]),
            );
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
            'index' => ListJobPositions::route('/'),
            'create' => CreateJobPosition::route('/create'),
            'edit' => EditJobPosition::route('/{record}/edit'),
        ];
    }
}
