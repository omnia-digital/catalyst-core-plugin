<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Settings\GeneralSettings;

class SettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new GeneralSettings([
            'site_name' => 'Catalyst Core',
            'site_active' => true,
            'teams_apply_button_text' => 'Apply',
            'allow_guest_access' => true,
            'should_show_login_on_guest_access' => true
        ]))->save();
    }
}
