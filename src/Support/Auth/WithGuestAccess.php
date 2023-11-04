<?php

namespace OmniaDigital\CatalystCore\Support\Auth;

use OmniaDigital\CatalystCore\Catalyst;

trait WithGuestAccess
{
    public function showAuthenticationModal(string $redirect = null)
    {
        $this->dispatch('showAuthenticationModal', redirect: $redirect)->to('authentication-modal');
    }

    public function redirectToAuthenticationPage()
    {
        if (Catalyst::shouldShowLoginOnGuestAccess()) {
//            $this->redirectRoute(config('catalyst-settings.login_route'));

            return;
        }

        $this->redirectRoute('register');
    }
}
