<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Models\Jobs\HoursPerWeek;
class HoursPerWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hours = [
            'Less than 5',
            '5-10',
            '10-20',
            '20-30',
            '30+',
        ];

        foreach ($hours as $hour) {
            HoursPerWeek::create(['value' => $hour]);
        }
    }
}
