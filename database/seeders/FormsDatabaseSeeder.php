<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystForms\Models\FormType;

class FormsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Default Form Types
        $registrationFormType = FormType::create([
            'name' => Translate::get('Registration'),
            'slug' => 'registration',
            'for' => 'admin',
        ]);
        $teamResourceRequestForm = FormType::create([
            'name' => Translate::get('Team Resource Request'),
            'slug' => 'team-resource-request',
            'for' => 'teams',
        ]);
        $teamMemberApplicationForm = FormType::create([
            'name' => Translate::get('Team Member Application Form'),
            'slug' => 'team-member-application-form',
            'for' => 'teams',
        ]);
        $teamMemberForm = FormType::create([
            'name' => Translate::get('Team Member Form'),
            'slug' => 'team-member-form',
            'for' => 'teams',
        ]);
    }
}
