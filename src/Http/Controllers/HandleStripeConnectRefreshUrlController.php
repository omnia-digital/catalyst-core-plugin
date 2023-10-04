<?php

namespace OmniaDigital\CatalystCore\Http\Controllers;

use Illuminate\Http\Request;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Support\StripeConnect\StripeConnect;

class HandleStripeConnectRefreshUrlController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var Team $team */
        $team = $request->user()->currentTeam;

        if (! $team) {
            return route('social.home');
        }

        $accountLink = app(StripeConnect::class)->createAccountLink(
            accountStripeId: $team->stripe_connect_id,
            returnUrl: route('social.teams.subscriptions', $team)
        );

        return redirect()->to($accountLink->url);
    }
}
