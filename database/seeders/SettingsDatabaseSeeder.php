<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use OmniaDigital\CatalystCore\Settings\BillingSettings;
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

        (new BillingSettings([
            'payment_gateway' => 'stripe',
            'user_subscriptions' => false,
            'team_subscriptions' => false,
            'team_member_subscriptions' => false,
            'user_subscription_form' => 'user-subscriptions',
            'change_payment_method_form' => 'change-payment-method',
            'show_user_subscription_plan_in_navigation' => false,
            'show_user_subscription_plan_in_profile_header' => false,
            'application_fee_percent' => 10,
        ]))->save();
    }
}
