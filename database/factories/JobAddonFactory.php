<?php

namespace OmniaDigital\CatalystCore\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use OmniaDigital\CatalystCore\Models\Jobs\JobPositionAddon;

class JobAddonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobPositionAddon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $name = $this->faker->name,
            'code' => Str::slug($name),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(10, 100),
        ];
    }
}
