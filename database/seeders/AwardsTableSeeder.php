<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use OmniaDigital\CatalystCore\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Models\Award;

class AwardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Award::truncate();

        $awards = Award::factory(10)->create();

        foreach (User::all() as $user) {
            $user->awards()->attach(
                $awards->random(rand(1, 3))->pluck('id')->toArray()
            );
        }

        foreach (Team::all() as $team) {
            $team->awards()->attach(
                $awards->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
