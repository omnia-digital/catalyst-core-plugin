<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('jobs.featured_days', '7');
        $this->migrator->add('jobs.featured_jobs_limit', 8);
        $this->migrator->add('jobs.posting_price', 30);
    }
};
