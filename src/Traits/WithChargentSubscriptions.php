<?php

namespace OmniaDigital\CatalystCore\Traits;

use OmniaDigital\CatalystCore\Models\ChargentSubscription;

trait WithChargentSubscriptions
{
    public function chargentSubscription()
    {
        if (! class_exists(ChargentSubscription::class)) {
            return;
        }

        return $this->hasOne(ChargentSubscription::class);
    }
}
