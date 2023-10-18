<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        Profile::truncate();

        Profile::factory(15)->create();
    }
}
