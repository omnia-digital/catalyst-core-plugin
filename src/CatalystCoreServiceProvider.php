<?php

namespace OmniaDigital\CatalystCore;

use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Livewire\Features\SupportTesting\Testable;
use OmniaDigital\CatalystCore\Commands\CatalystCoreCommand;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;
use OmniaDigital\CatalystCore\Providers\EventServiceProvider;
use OmniaDigital\CatalystCore\Providers\FortifyServiceProvider;
use OmniaDigital\CatalystCore\Providers\JetstreamServiceProvider;
use OmniaDigital\CatalystCore\Providers\RouteServiceProvider;
use OmniaDigital\CatalystCore\Providers\StripeConnectServiceProvider;
use OmniaDigital\CatalystCore\Providers\TeamLensesServiceProvider;
use OmniaDigital\CatalystCore\Settings\GeneralSettings;
use OmniaDigital\CatalystCore\Testing\TestsCatalystCore;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CatalystCoreServiceProvider extends PackageServiceProvider
{
    public static string $name = 'catalyst-core-plugin';

    public static string $viewNamespace = 'catalyst-core-plugin';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('omnia-digital/catalyst-core-plugin');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        # add settings config file
        $configFileName = 'catalyst-settings';
        $package->hasConfigFile($configFileName);


        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(StripeConnectServiceProvider::class);
        $this->app->register(TeamLensesServiceProvider::class);
        $this->app->register(JetstreamServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/catalyst-core-plugin/{$file->getFilename()}"),
                ], 'catalyst-core-plugin-stubs');
            }
        }

        Gate::define('update-profile', function (User $user, Profile $profile) {
            return $user->id === $profile->user_id;
        });

        Gate::define('update-team', function (User $user, Team $team) {
            return $user->belongsToTeam($team) &&
                ($user->hasTeamRole($team, 'admin') ||
                    $user->ownsTeam($team));
        });

        Blade::if('guestAccess', function () {
            return (new GeneralSettings)->allow_guest_access;
        });

        // Testing
        Testable::mixin(new TestsCatalystCore());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'omnia-digital/catalyst-core-plugin';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('catalyst-core-plugin', __DIR__ . '/../resources/dist/components/catalyst-core-plugin.js'),
            //            Css::make('catalyst-core-plugin-styles', __DIR__ . '/../resources/dist/catalyst-core-plugin.css'),
            //            Js::make('catalyst-core-plugin-scripts', __DIR__ . '/../resources/dist/catalyst-core-plugin.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            CatalystCoreCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_catalyst-core-plugin_table',
        ];
    }
}
