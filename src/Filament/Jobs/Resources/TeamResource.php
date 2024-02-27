<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Resources;

use App\Models\User;
use Filament\Facades\Filament;
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
            Forms\Components\SpatieMediaLibraryFileUpload::make('profile_photo_path')
                ->image()
                ->avatar(),
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('handle')
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('summary')->label('About')
                ->maxLength(65535),
            Forms\Components\Textarea::make('content')
                ->maxLength(65535)
                ->required(),
//            Forms\Components\DateTimePicker::make('start_date'),
//            Forms\Components\TextInput::make('location')
//                ->maxLength(255),
//            Forms\Components\TextInput::make('rating'),
//            Forms\Components\TextInput::make('languages')
//                ->required()
//                ->maxLength(255),
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
            \OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource\RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource\Pages\ListTeams::route('/'),
            'create' => \OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource\Pages\CreateTeam::route('/create'),
            'view' => \OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource\Pages\ViewTeam::route('/{record}'),
            'edit' => \OmniaDigital\CatalystCore\Filament\Jobs\Resources\TeamResource\Pages\EditTeam::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return Translate::get('Settings');
    }

    public static function getNavigationLabel(): string
    {
        return Translate::get('My Teams');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()
            ->get()
            ->count();
    }

    //    public static function getEloquentQuery(): Builder
    //    {
    //        if (auth()->user()->is_admin) {
    //            return parent::getEloquentQuery();
    //        } else {
    //            return parent::getEloquentQuery()->whereIn('id', auth()->user()->ownedTeams->pluck('id'));
    //        }
    //    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $user = Filament::auth()->user();
        if (! empty($user)) {
            return parent::getEloquentQuery()
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('model_has_roles.model_id', $user->id)
                        ->where('model_has_roles.model_type', User::class);
                });
        }
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getEloquentQuery()
            ->get()
            ->count() > 10 ? 'warning' : 'primary';
    }
}
