<?php

namespace OmniaDigital\CatalystCore\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use OmniaDigital\CatalystCore\Actions\Teams\CreateTeam;
use OmniaDigital\CatalystCore\Models\Team;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param array<string, string> $input
     */
    public function create(array $input): User
    {
//        Validator::make($input, [
//            'first_name' => ['required', 'string', 'max:255'],
//            'last_name' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => $this->passwordRules(),
////            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
////            'role' => [Rule::in(['Client', 'Contractor'])],
//        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(config('catalyst-settings.models.user')::create([
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use ($input) {
                $this->createProfile($user, $input);
                $this->createTeam($user);
//                    $this->assignRole($user, $input['role'] ?? 'Client'); // Default role is Client.
            });
        });

        // fire off this job to sendgrid on New user Event, not in here
//        $json_data = '{
//          "list_ids": ["' . config('app.sendgrid_company_list_id') . '"],
//          "contacts": [
//            {
//              "email": "' . $input['email'] . '"
//            }
//          ]
//        }';
//        $response = Http::withToken(config('app.sendgrid_key'))->withBody($json_data,
//            'application/json')->put(config('app.sendgrid_url'));
//        if ($response->status() == 202) {
//
//        }
    }

    /**
     * Create a profile for the user.
     *
     * @return void
     */
    public function createProfile(User $user, $input)
    {
        $user->profile()->create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
        ]);
    }
    public function createTeam(User $user): void
    {
        (new CreateTeam())->create($user, [
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'teamTypes' => [],
        ]);
//        $user->teams()->save(Team::forceCreate([
//            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
//        ]));
    }
}
