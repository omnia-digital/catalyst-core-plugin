<?php

namespace OmniaDigital\CatalystCore\Traits\Transaction;

use OmniaDigital\CatalystCore\Models\Jobs\Transaction;

trait HasTransaction
{
    /**
     * Get transactions of a model.
     *
     * @return mixed
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
