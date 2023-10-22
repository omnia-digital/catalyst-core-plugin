<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Pages\Billing\Stripe\Team;

use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laravel\Cashier\Subscription;
use Livewire\Component;
use OmniaDigital\CatalystCore\Actions\Teams\CreateStripeConnectAccountForTeamAction;
use OmniaDigital\CatalystCore\Support\StripeConnect\StripeConnect;

class AdminSubscriptions extends Component
{
    use AuthorizesRequests;

    public Team $team;

    public function mount()
    {
        $this->authorize('manageMembership', $this->team);

        $this->updateOnboardingProcessCompleted();
    }

    public function updateOnboardingProcessCompleted()
    {
        if (! $this->team->hasStripeConnectAccount()) {
            return;
        }

        // Complete, nothing to update
        if ($this->team->stripeConnectOnboardingCompleted()) {
            return;
        }

        $account = app(StripeConnect::class)->getAccount($this->team->stripe_connect_id);

        $this->team->update(['stripe_connect_onboarding_completed' => $account->details_submitted]);
    }

    public function connectStripe()
    {
        if (! $this->team->hasStripeConnectAccount()) {
            (new CreateStripeConnectAccountForTeamAction)->execute($this->team);

            $this->team->refresh();
        }

        $accountLink = app(StripeConnect::class)->createAccountLink(
            accountStripeId: $this->team->stripe_connect_id,
            returnUrl: route('social.teams.admin', $this->team)
        );

        $this->redirect($accountLink->url);
    }

    public function getRowsQueryProperty()
    {
        return Subscription::query()
            ->with('owner')
            ->where('team_id', $this->team->id);
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(25);
    }

    public function render()
    {
        return view('billing::livewire.pages.billing.stripe.team.admin-subscriptions', [
            'subscriptions' => $this->rows,
            'plans' => collect(config('team-user-subscription.plans')),
        ]);
    }
}
