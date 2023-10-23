<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\NewCommentNotification;
use Modules\Social\Notifications\NewFollowerNotification;
use Modules\Social\Notifications\PostWasRepostedNotification;

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
