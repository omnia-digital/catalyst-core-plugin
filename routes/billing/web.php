<?php


use Illuminate\Support\Facades\Route;
use OmniaDigital\CatalystCore\Livewire\Pages\Billing\Stripe\User\Billing as StripBillingPage;
use OmniaDigital\CatalystCore\Livewire\Pages\Billing\Chargent\User\Subscription as ChargentBillingPage;

// Billing
Route::name('billing.')
    ->prefix('billing')
    ->group(function () {
        Route::get('billing', StripBillingPage::class)
            ->name('stripe-billing'); // stripe billing page
        Route::get('/subscription', ChargentBillingPage::class)
            ->withoutMiddleware('subscribed')
            ->name('chargent-billing'); // chargent billing
    });
