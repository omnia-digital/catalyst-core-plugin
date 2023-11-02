<?php

namespace OmniaDigital\CatalystCore\Actions\Teams;

use Illuminate\Foundation\Auth\User as Authenticatable;
use OmniaDigital\CatalystCore\Models\StripeConnectCustomer;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Models\User;
use OmniaDigital\CatalystCore\Support\StripeConnect\StripeConnect;

/** @note We are not using this currently. Save for future when we want teams to create custom plans */
class CreateStripeConnectCustomerAction
{
    public function execute(Team $team, User | Authenticatable $user): StripeConnectCustomer
    {
        if ($user->isStripeConnectCustomerOf($team)) {
            return $user->stripeConnectCustomerOf($team);
        }

        $stripeCustomer = app(StripeConnect::class)->createCustomer(
            stripeAccountId: $team->stripe_connect_id,
            email: $user->email
        );

        return $user->stripeConnectCustomers()->create([
            'team_id' => $team->id,
            'stripe_customer_id' => $stripeCustomer->id,
        ]);
    }
}
