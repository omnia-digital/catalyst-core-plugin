<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Models\EventSourceCalendar;
use OmniaDigital\CatalystCore\Models\EventSourceCalendarType;

class EventCalendarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $googleSourceCalendarType = EventSourceCalendarType::create([
            'name' => 'Google Calendar'
        ]);
    }
}
