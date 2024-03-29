<?php

namespace OmniaDigital\CatalystCore\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\OmniaDigital\CatalystCore\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => strtolower($this->faker->month()) . '_type',
            'name' => $this->faker->jobTitle(),
        ];
    }
}
