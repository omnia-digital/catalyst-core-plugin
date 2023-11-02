<?php

namespace OmniaDigital\CatalystCore\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use OmniaDigital\CatalystCore\Models\Award;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AwardFactory extends Factory
{
    protected $model = Award::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word() . ' Award',
            'icon' => 'heroicon-o-academic-cap',
        ];
    }
}
