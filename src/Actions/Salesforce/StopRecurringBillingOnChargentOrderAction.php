<?php

namespace OmniaDigital\CatalystCore\Actions\Salesforce;

use OmniaDigital\CatalystCore\Models\ChargentSubscription;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class StopRecurringBillingOnChargentOrderAction
{
    public function execute(ChargentSubscription $subscription)
    {
        if (! $subscription->chargent_order_id) {
            return null;
        }

        Forrest::authenticate();

        Forrest::sobjects("ChargentOrders__ChargentOrder__c/{$subscription->chargent_order_id}", [
            'method' => 'patch',
            'body' => [
                'ChargentOrders__Payment_Status__c' => 'Stopped',
                'ChargentOrders__Payment_Stop__c' => 'Date',
                'ChargentOrders__Payment_End_Date__c' => now(),
            ],
        ]);

        $subscription->update([
            'status' => 'Stopped',
            'ends_at' => now(),
        ]);
    }
}
