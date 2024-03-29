<?php

namespace OmniaDigital\CatalystCore;

use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Theme;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Facades\FilamentView;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Component;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Livewire\LivewireServiceProvider;
use OmniaDigital\CatalystCore\Commands\CatalystCoreCommand;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Models\Team;
use App\Models\User;
use OmniaDigital\CatalystCore\Policies\Jobs\JobPositionPolicy;
use OmniaDigital\CatalystCore\Policies\TeamPolicy;
use OmniaDigital\CatalystCore\Providers\EventServiceProvider;
use OmniaDigital\CatalystCore\Providers\Filament\AdminPanelProvider;
use OmniaDigital\CatalystCore\Providers\Filament\JobsPanelProvider;
use OmniaDigital\CatalystCore\Providers\Filament\SocialPanelProvider;
use OmniaDigital\CatalystCore\Providers\FortifyServiceProvider;
use OmniaDigital\CatalystCore\Providers\JetstreamServiceProvider;
use OmniaDigital\CatalystCore\Providers\StripeConnectServiceProvider;
use OmniaDigital\CatalystCore\Providers\TeamLensesServiceProvider;
use OmniaDigital\CatalystCore\Settings\GeneralSettings;
use OmniaDigital\CatalystCore\Testing\TestsCatalystCore;
use ReflectionClass;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SplFileInfo;

class CatalystCoreServiceProvider extends PackageServiceProvider
{
    public static string $name = 'catalyst-core-plugin';

    public static string $viewNamespace = 'catalyst';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasRoutes($this->getRoutes())
            ->hasViews()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->publishAssets()
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
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
            $this->loadMigrationsFrom(__DIR__ . '/../database/settings/');
            $package->runsMigrations();
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }

        // Blade Components
        if (file_exists($package->basePath('/View/Components'))) {
            $package->hasViewComponents($this->getViewComponents());
            $this->registerBladeComponents($package);
        }

        // Livewire Components
        if (file_exists($package->basePath('/Livewire'))) {
            $this->registerLivewireComponents($package);
        }
    }

    public function getViewComponents()
    {
        $components = collect();
        foreach (app(Filesystem::class)->files(__DIR__ . '/View/Components') as $file) {
            $components->push($file->getBasename(suffix: '.php'));
        }
        return $components;
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

//    /**
//     * @return array<string>
//     */
//    protected function getMigrations() : Collection
//    {
//        $migrations = collect();
//        foreach (app(Filesystem::class)->files(__DIR__ . '/../database/migrations/') as $file) {
//            $migrations->push($file->getBasename(suffix: '.php'));
//        }
//        $this->loadMigrationsFrom(__DIR__ . '/../database/settings/');
//        return $migrations;
//    }

    public function registerBladeComponents($package)
    {
        $this->callAfterResolving(BladeCompiler::class, function () use ($package) {
            if (class_exists(\Illuminate\View\Component::class) && file_exists($package->basePath('/View/Components'))) {
                $namespace = 'OmniaDigital\CatalystCore\View\Components';
                $_directory = Str::of($package->basePath('/View/Components'))
                    ->replace('\\', '/')
                    ->toString();

                $this->registerBladeComponentClassDirectory($_directory, $namespace);
            }
        });
    }

    /**
     * Register component directory.
     *
     * @param string $directory
     * @param string $namespace
     * @param string $aliasPrefix
     *
     * @return void
     */
    protected function registerBladeComponentClassDirectory(string $directory, string $namespace): void
    {
        $filesystem = new Filesystem();

        /**
         * Directory doesn't existS.
         */
        if (!$filesystem->isDirectory($directory)) {
            return;
        }

        collect($filesystem->allFiles($directory))
            ->map(fn(SplFileInfo $file) => Str::of($namespace)
                ->append("\\{$file->getRelativePathname()}")
                ->replace(['/', '.php'], ['\\', ''])
                ->toString())
            ->filter(fn($class) => (is_subclass_of($class,
                    \Illuminate\View\Component::class) && !(new ReflectionClass($class))->isAbstract()))
            ->each(function ($class) use ($namespace) {
                $this->registerSingleBladeComponent($class, $namespace);
            });
    }

    /**
     * Register livewire single component.
     *
     * @param string $class
     * @param string $namespace
     * @param string $aliasPrefix
     *
     * @return void
     */
    private function registerSingleBladeComponent(string $class, string $namespace): void
    {
        $alias = Str::of($class)
            ->after($namespace . '\\')
            ->replace(['/', '\\'], '.')
            ->explode('.')
            ->map([Str::class, 'kebab'])
            ->implode('.');

        $prefix = 'catalyst::x-';
        $blade = Blade::component($alias, $class);

        Str::endsWith($class, ['\Index', '\index'])
            ? Blade::component($prefix . Str::beforeLast($alias, '.index'), $class)
            : Blade::component($prefix . $alias, $class);
    }

    public function registerLivewireComponents($package)
    {
        $this->callAfterResolving(BladeCompiler::class, function () use ($package) {
            if (class_exists(Livewire::class) && file_exists($package->basePath('/Livewire'))) {
                $namespace = 'OmniaDigital\CatalystCore\Livewire';
                $_directory = Str::of($package->basePath('/Livewire'))
                    ->replace('\\', '/')
                    ->toString();

                $this->registerLivewireComponentClassDirectory($_directory, $namespace);
            }
        });
    }

    /**
     * Register component directory.
     *
     * @param string $directory
     * @param string $namespace
     * @param string $aliasPrefix
     *
     * @return void
     */
    protected function registerLivewireComponentClassDirectory(string $directory, string $namespace): void
    {
        $filesystem = new Filesystem();

        /**
         * Directory doesn't existS.
         */
        if (!$filesystem->isDirectory($directory)) {
            return;
        }

        $aliases = collect();

        collect($filesystem->allFiles($directory))
            ->map(fn(SplFileInfo $file) => Str::of($namespace)
                ->append("\\{$file->getRelativePathname()}")
                ->replace(['/', '.php'], ['\\', ''])
                ->toString())
            ->filter(fn($class) => (is_subclass_of($class,
                    Component::class) && !(new ReflectionClass($class))->isAbstract()))
            ->each(function ($class) use ($namespace, $aliases) {
                $alias = Str::of($class)
                    ->after($namespace . '\\')
                    ->replace(['/', '\\'], '.')
                    ->explode('.')
                    ->map([Str::class, 'kebab'])
                    ->implode('.');
                $aliases->push($alias);
                $this->registerSingleLivewireComponent($class, $namespace);
            });
    }

    /**
     * Register livewire single component.
     *
     * @param string $class
     * @param string $namespace
     * @param string $aliasPrefix
     *
     * @return void
     */
    private function registerSingleLivewireComponent(string $class, string $namespace): void
    {
        $alias = Str::of($class)
            ->after($namespace . '\\')
            ->replace(['/', '\\'], '.')
            ->explode('.')
            ->map([Str::class, 'kebab'])
            ->implode('.');

        $prefix = 'catalyst::';
        Livewire::component($alias, $class);

        Str::endsWith($class, ['\Index', '\index'])
            ? Livewire::component($prefix . Str::beforeLast($alias, '.index'), $class)
            : Livewire::component($prefix . $alias, $class);
    }

    public function packageRegistered(): void
    {
        $this->app->register(FortifyServiceProvider::class);
        $this->app->register(JetstreamServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(LivewireServiceProvider::class);
        $this->app->register(TeamLensesServiceProvider::class);
        $this->app->register(StripeConnectServiceProvider::class);
        $this->app->register(AdminPanelProvider::class);
//        $this->app->register(SocialPanelProvider::class);
        $this->app->register(JobsPanelProvider::class);
        Gate::policy(JobPosition::class, JobPositionPolicy::class);
        Gate::policy(Team::class, TeamPolicy::class);
        Gate::policy(\App\Models\Team::class, TeamPolicy::class);
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

        // Seeders
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../database/seeders/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("database/seeders/{$file->getFilename()}"),
                ], 'catalyst-core-plugin-seeders');
            }
        }

        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../database/factories/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("database/factories/{$file->getFilename()}"),
                ], 'catalyst-core-plugin-factories');
            }
        }

        // Handle Stubs
//        if (app()->runningInConsole()) {
//            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
//                $this->publishes([
//                    $file->getRealPath() => base_path("stubs/catalyst-core-plugin/{$file->getFilename()}"),
//                ], 'catalyst-core-plugin-stubs');
//            }
//        }

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

        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->simple()
                ->visible(fn (): bool => auth()->user()->is_admin)
                ->canSwitchPanels(fn (): bool => auth()->user()->is_admin)
//            ->excludes(['admin'])
            ->renderHook('panels::sidebar.nav.start');
        });

        // Testing
        Testable::mixin(new TestsCatalystCore());
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('catalyst-core-plugin', __DIR__ . '/../resources/dist/components/catalyst-core-plugin.js'),
//            Css::make('catalyst-core-plugin-styles', __DIR__ . '/../resources/dist/catalyst-core-plugin.css'),
            Js::make('catalyst-core-plugin-scripts', __DIR__ . '/../resources/dist/catalyst-core-plugin.js'),
        ];
    }

    protected function getAssetPackageName(): ?string
    {
        return 'omnia-digital/catalyst-core-plugin';
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
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return ['web','api'];
    }
}
