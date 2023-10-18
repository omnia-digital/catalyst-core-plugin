<?php

namespace OmniaDigital\CatalystSocialPlugin\Database\Seeders;

use Illuminate\Database\Seeder;
use OmniaDigital\CatalystSocialPlugin\Models\Bookmark;

class BookmarksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        Bookmark::truncate();

        // Posts
        Bookmark::factory(25)->create();
    }
}
