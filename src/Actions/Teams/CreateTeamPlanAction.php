<?php

namespace OmniaDigital\CatalystCore\Actions\Teams;

use App\Support\StripeConnect\StripeConnect;
use Exception;
use Illuminate\Support\Facades\DB;
use OmniaDigital\CatalystCore\Models\Team;

class CreateTeamPlanAction
{
    protected float $amount;

    protected string $billingPeriod;

    public function price(float $amount, string $billingPeriod): self
    {
        $this->amount = $amount;
        $this->billingPeriod = $billingPeriod;

        return $this;
    }

    public function execute(Team $team, string $name, ?string $description = null)
    {
        if (! $team->hasStripeConnectAccount()) {
            throw new Exception('This team does not have a Stripe Connect account!');
        }

        $product = app(StripeConnect::class)->createProduct(
            stripeAccountId: $team->stripe_connect_id,
            name: $name,
            description: $description
        );

        $price = app(StripeConnect::class)->createPrice(
            stripeAccountId: $team->stripe_connect_id,
            productId: $product->id,
            amount: $this->amount,
            billingPeriod: $this->billingPeriod
        );

        DB::transaction(function () use ($team, $product, $price) {
            $plan = $team->teamPlans()->create([
                'name' => $product->name,
                'description' => $product->description,
                'stripe_id' => $product->id,
            ]);

            $plan->prices()->create([
                'stripe_id' => $price->id,
                'amount' => $price->unit_amount_decimal,
                'billing_period' => $price->recurring->interval,
            ]);
        });
    }
}
