<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Models\Mention;

class MentionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Mention::truncate();

        Mention::factory(15)->create();
    }
}
