<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('billing.show_user_subscription_plan_in_navigation', false);
        $this->migrator->add('billing.show_user_subscription_plan_in_profile_header', false);
    }
};
