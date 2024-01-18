<?php

namespace OmniaDigital\CatalystCore\Support\Jobs;

use Illuminate\Database\Eloquent\Relations\HasMany;
use OmniaDigital\CatalystCore\Models\Jobs\Transaction;

trait HasTransactions
{
    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
