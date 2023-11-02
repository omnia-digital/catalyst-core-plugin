<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use Modules\Advice\OmniaDigital\CatalystCore\Database\Seeders\AdviceDatabaseSeeder;
use OmniaDigital\CatalystCore\Database\Seeders\BillingDatabaseSeeder;
use OmniaDigital\CatalystCore\Database\Seeders\FormsDatabaseSeeder;
use OmniaDigital\CatalystCore\Database\Seeders\ResourcesDatabaseSeeder;
use OmniaDigital\CatalystCore\Database\Seeders\ReviewsDatabaseSeeder;
use OmniaDigital\CatalystCore\Database\Seeders\SocialDatabaseSeeder;

class CatalystDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (DB::connection() instanceof \Illuminate\Database\MySqlConnection) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        $this->call(SettingsDatabaseSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TeamTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(AwardsTableSeeder::class);
        $this->call(SocialDatabaseSeeder::class);
//        $this->call(ResourcesDatabaseSeeder::class);
//        $this->call(AdviceDatabaseSeeder::class);
        $this->call(NotificationTableSeeder::class);
        $this->call(LanguageTableSeeder::class);
//        $this->call(ReviewsDatabaseSeeder::class);
        $this->call(BillingDatabaseSeeder::class);
        $this->call(FormsDatabaseSeeder::class);
        if (DB::connection() instanceof \Illuminate\Database\MySqlConnection) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        Model::reguard();
    }
}
