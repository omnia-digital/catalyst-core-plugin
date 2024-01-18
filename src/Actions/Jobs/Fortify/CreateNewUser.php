<?php

namespace OmniaDigital\CatalystCore\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @return User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => [Rule::in(['Client', 'Contractor'])],
        ])->validate();

        $json_data = '{
          "list_ids": ["'.config('app.sendgrid_company_list_id').'"],
          "contacts": [
            {
              "email": "'.$input['email'].'"
            }
          ]
        }';

        $response = Http::withToken(config('app.sendgrid_key'))->withBody($json_data,
            'application/json')->put(config('app.sendgrid_url'));
        //202 Accepted
        if ($response->status() == 202) {
            return DB::transaction(function () use ($input) {
                return tap(User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                ]), function (User $user) use ($input) {
                    $this->assignRole($user, $input['role'] ?? 'Client'); // Default role is Client.
                    $this->createCompany($user);
                });
            });
        }
    }

    /**
     * Assign role to user.
     */
    protected function assignRole(User $user, string $role)
    {
        $user->assignRole($role);
    }

    /**
     * Create a personal company for the user.
     *
     * @return void
     */
    protected function createCompany(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Company",
            'personal_team' => true,
        ]));
    }
}
