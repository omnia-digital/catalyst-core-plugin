<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Resources;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use OmniaDigital\CatalystCore\Models\Post;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Social';
protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('body'),
                TextInput::make('title'),
Select::make('user_id')->relationship('user','name'),
//                'user_id',
//                'team_id',
//                'title',
//                'type',
//                'body',
//                'url',
//                'postable_id',
//                'postable_type',
//                'repost_original_id',
//                'published_at',
//                'image',
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->limit(25)->sortable()->searchable(),
                TextColumn::make('body')->limit(50)->searchable(),
                TextColumn::make('user.name')->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
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
            'index' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\PostResource\Pages\ListPosts::route('/'),
            'create' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\PostResource\Pages\CreatePost::route('/create'),
            'edit' => \OmniaDigital\CatalystCore\Filament\Admin\Resources\PostResource\Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
