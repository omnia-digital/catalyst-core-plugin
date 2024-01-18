<?php

namespace OmniaDigital\CatalystCore\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Models\Team;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withTeam()
    {
        if (!Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        $team = Team::factory()->create();

        $role = Role::create([
            'name' => config('platform.teams.default_owner_role'),
            'team_id' => $team->id,
        ]);

        return $this->hasAttached(
            $team,
            ['role_id' => $role->id, 'team_id' => $team->id],
            'teams'
        );
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @param $position
     * @return $this
     */
    public function withExistingTeam()
    {
        if (!Features::hasTeamFeatures()) {
            return $this->state([]);
        }
        $team = Team::get()->shuffle()->first();

        $member = config('platform.teams.default_member_role');

        setPermissionsTeamId($team->id);

        return $this->hasAttached(
            $team,
            ['role_id' => Role::findOrCreate($member)->id, 'team_id' => $team->id],
            'teams'
        );
    }

    /**
     * Indicate that the user should have a profile.
     *
     * @return $this
     */
    public function withProfile($fillData = [])
    {
        if (!class_exists(Profile::class)) {
            return;
        }

        return $this->has(
            Profile::factory()
                ->state(function (array $attributes, User $user) use ($fillData) {
                    return [
                        'user_id' => $user->id,
                        'first_name' => $fillData['first_name'] ?? $attributes['first_name'],
                        'last_name' => $fillData['last_name'] ?? $attributes['last_name'],
                    ];
                })
        );
    }
}
