<?php

namespace OmniaDigital\CatalystSocialPlugin\Database\Seeders;

use Illuminate\Database\Seeder;
use OmniaDigital\CatalystSocialPlugin\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        Profile::truncate();

        Profile::factory(15)->create();
    }
}
