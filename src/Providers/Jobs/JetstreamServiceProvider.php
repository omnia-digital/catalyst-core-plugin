<?php

namespace OmniaDigital\CatalystCore\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use OmniaDigital\CatalystCore\Actions\Jetstream\AddTeamMember;
use OmniaDigital\CatalystCore\Actions\Jetstream\CreateTeam;
use OmniaDigital\CatalystCore\Actions\Jetstream\DeleteTeam;
use OmniaDigital\CatalystCore\Actions\Jetstream\DeleteUser;
use OmniaDigital\CatalystCore\Actions\Jetstream\UpdateTeamName;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', __('Administrator'), [
            'create',
            'read',
            'update',
            'delete',
        ])->description(__('Administrator users can perform any action.'));

        Jetstream::role('editor', __('Editor'), [
            'read',
            'create',
            'update',
        ])->description(__('Editor users have the ability to read, create, and update.'));
    }
}
