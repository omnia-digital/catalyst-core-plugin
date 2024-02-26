<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use OmniaDigital\CatalystCore\Settings\GeneralSettings;

class ManageGeneralSettings extends SettingsPage
{
    use HasPageShield;

    protected static ?string $title = 'General Settings';

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = -100;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_name')
                ->required(),
            FileUpload::make('site_header_logo')->directory('logos')->visibility('public'),
            FileUpload::make('site_login_logo')->directory('logos')->visibility('public'),
            TextInput::make('teams_apply_button_text')
                ->required(),
            Toggle::make('allow_guest_access')
                ->label('Allow Guest Access to Catalyst?')
                ->inline(false),
            Toggle::make('should_show_login_on_guest_access')
                ->label('Show Login Modal/Page on Guest Access?')
                ->inline(false),
        ];
    }
}
