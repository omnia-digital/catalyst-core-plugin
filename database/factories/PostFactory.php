<?php

namespace OmniaDigital\CatalystCore\Database\Factories;

use OmniaDigital\CatalystCore\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use OmniaDigital\CatalystCore\Enums\PostType;
use OmniaDigital\CatalystCore\Models\Post;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'body' => $this->faker->paragraph(4),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function asResource(): PostFactory
    {
        return $this->withType(PostType::RESOURCE)->state([
            'body' => $this->faker->company(),
        ]);
    }

    /**
     * @return $this
     */
    public function withType($type): static
    {
        return $this->state([
            'type' => $type,
        ]);
    }

    public function asArticle(): PostFactory
    {
        return $this->withType(PostType::ARTICLE)->state([
            'title' => $this->faker->company(),
        ]);
    }

    public function asQuestion(): PostFactory
    {
        return $this->withType(PostType::QUESTION)->state([
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph(6),
        ]);
    }

    /**
     * @return $this
     */
    public function withReplies($replies = 5)
    {
        return $this->has(
            Post::factory($replies)
                ->state(function (array $attributes, Post $post) {
                    return [
                        'postable_id' => $post->id,
                        'postable_type' => Post::class,
                    ];
                })
        );
    }
}
