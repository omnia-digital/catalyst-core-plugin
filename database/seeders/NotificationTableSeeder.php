<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Models\User;
use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Notifications\NewCommentNotification;
use OmniaDigital\CatalystCore\Notifications\NewFollowerNotification;
use OmniaDigital\CatalystCore\Notifications\PostWasRepostedNotification;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            $user->notify(new NewFollowerNotification(User::inRandomOrder()->first()));
            $user->notify(new NewCommentNotification(Post::inRandomOrder()->first(), User::inRandomOrder()->first()));
            $user->notify(new PostWasRepostedNotification(Post::inRandomOrder()->first(), User::inRandomOrder()->first()));
        }
    }
}
