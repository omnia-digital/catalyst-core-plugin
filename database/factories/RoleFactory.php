<?php

namespace OmniaDigital\CatalystCore\Database\Factories;

use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Jetstream\Features;
use OmniaDigital\CatalystCore\Models\Profile;
use Spatie\Permission\Models\Role;
use OmniaDigital\CatalystCore\Facades\Translate;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle(),
            'team_id' => null,
        ];
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        $teamOwnerRole = Role::create([
            'name' => config('platform.teams.default_owner_role'),
            'team',
        ]);

        return $this->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->profile->name . '\'s ' . Translate::get('Team')];
                }),
            ['role_id' => $teamOwnerRole->id],
            'teams'
        );
    }

    /**
     * Indicate that the user should have a profile.
     *
     * @return $this
     */
    public function withProfile()
    {
        if (! class_exists(Profile::class)) {
            return;
        }

        return $this->has(
            Profile::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'user_id' => $user->id,
                        'first_name' => $attributes['first_name'],
                        'last_name' => $attributes['last_name'],
                    ];
                })
        );
    }
}
