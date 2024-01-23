<?php

namespace OmniaDigital\CatalystCore\Filament\Social\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Filament\Admin\Resources\EventResource;
use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;
use OmniaDigital\CatalystCore\Models\Event;

class CalendarPage extends BasePage
{
    use InteractsWithRecord;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'catalyst::filament.pages.social.calendar';
    protected static ?string $slug = 'calendar';
    protected static ?string $navigationLabel = 'Calendar';
    protected static ?string $title = 'Calendar';
    protected static ?int $navigationSort = 100;
    protected static bool $shouldRegisterNavigation = true;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Submit New Event')->url(route('filament.social.resources.events.create')),
        ];
    }
}
