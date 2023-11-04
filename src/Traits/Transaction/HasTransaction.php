<?php

namespace OmniaDigital\CatalystCore\Traits\Transaction;

use OmniaDigital\CatalystCore\Support\Transaction\Transaction;

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
