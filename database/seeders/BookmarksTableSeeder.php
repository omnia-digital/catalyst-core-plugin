<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Models\Bookmark;

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
