<?php

namespace OmniaDigital\CatalystCore\Models\Jobs;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class PaymentType extends Model
{
    use Sushi;

    protected $rows = [
        [
            'code' => 'hourly',
            'name' => 'Hourly',
        ],
        [
            'code' => 'fixed',
            'name' => 'Fixed',
        ],
    ];
}
