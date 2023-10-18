<?php

namespace OmniaDigital\CatalystSocialPlugin\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use OmniaDigital\CatalystSocialPlugin\Models\Profile;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'user_id' => User::factory(),
            'bio' => $this->faker->text,
        ];
    }
}
