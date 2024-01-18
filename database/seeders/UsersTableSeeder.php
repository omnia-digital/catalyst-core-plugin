<?php

namespace OmniaDigital\CatalystCore\Database\Seeders;

use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        $panelUserRole = Utils::getRoleModel()::firstOrCreate([
            'name' => 'panel_user',
            'guard_name' => 'web',
        ]);

        $adminUser = User::factory(1)->withProfile([
            'first_name' => 'Omnia',
            'last_name' => 'Admin',
        ])->withTeam()->create([
            'email' => 'admin@omniadigital.io',
            'password' => bcrypt('testing'),
        ]);

//        $adminUser->assignRole($panelUserRole);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Member1',
        ])->withExistingTeam()->create([
            'email' => 'teammember@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Jon',
            'last_name' => 'Doe',
        ])->withExistingTeam()->create([
            'email' => 'jondoe@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ])->withExistingTeam()->create([
            'email' => 'janedoe@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Owner',
        ])->withTeam()->create([
            'email' => 'teamowner@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Member 2',
        ])->withExistingTeam()->create([
            'email' => 'teammember2@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Member3',
        ])->withExistingTeam()->create([
            'email' => 'teammember3@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(1)->withProfile([
            'first_name' => 'Team',
            'last_name' => 'Member4',
        ])->withExistingTeam()->create([
            'email' => 'teammember4@test.com',
            'password' => bcrypt('testing'),
        ]);

        User::factory(10)->withProfile()->withTeam()->create();


        // Jobs User Seeder
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('secret'),
        ])->assignRole('Admin');

        $admin->ownedTeams()->save(Team::forceCreate([
            'user_id' => $admin->id,
            'name' => explode(' ', $admin->name, 2)[0]."'s Company",
            'personal_team' => true,
        ]));

        $admin->createAsStripeCustomer();

        $contractor = User::factory()->create([
            'name' => 'Contractor',
            'password' => Hash::make('secret'),
        ])->assignRole('Contractor');

        $contractor->ownedTeams()->save(Team::forceCreate([
            'user_id' => $contractor->id,
            'name' => explode(' ', $contractor->name, 2)[0]."'s Company",
            'personal_team' => true,
        ]));

        $contractor->createAsStripeCustomer();

        $client = User::factory()->create([
            'name' => 'Client',
            'password' => Hash::make('secret'),
        ])->assignRole('Client');

        $client->ownedTeams()->save(Team::forceCreate([
            'user_id' => $client->id,
            'name' => explode(' ', $client->name, 2)[0]."'s Company",
            'personal_team' => true,
        ]));

        $client->createAsStripeCustomer();
    }
}
