<?php

// Billing
use Illuminate\Support\Facades\Route;

Route::name('billing.')
    ->prefix('billing')
    ->group(function () {
        // @TODO [Josh] - this needs to be specific to chargent somehow
        Route::post('subscriptions', function (Request $request) {
            $user = User::findByEmail($request->email);

            $user->chargentSubscription()->firstOrCreate(
                ['chargent_order_id' => $request->chargent_order_object_id],
                [
                    'subscription_type_id' => SubscriptionType::where('slug', $request->subscription_type)->first()->id,
                    'card_type' => $request->card_type,
                    'last_4' => $request->last_4,
                ]
            );
        });
        Route::post('subscriptions/update', function (Request $request) {
            $user = User::findByEmail($request->email);

            $user->chargentSubscription()
                ->where('chargent_order_id', $request->chargent_order_object_id)
                ->latest()->first()->update([
                    'card_type' => $request->card_type,
                    'last_4' => $request->last_4,
                ]);
        });
    });
