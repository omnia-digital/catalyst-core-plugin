<?php

namespace OmniaDigital\CatalystCore\Database\Factories;

use OmniaDigital\CatalystCore\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use OmniaDigital\CatalystCore\Models\Bookmark;
use OmniaDigital\CatalystCore\Models\Post;

class BookmarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookmark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'bookmarkable_id' => Post::all()->random()->id,
            'bookmarkable_type' => Post::class,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
