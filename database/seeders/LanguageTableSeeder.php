<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Language::create([
            'name' => 'English',
            'slug' => 'en',
        ]);
    }
}
