<?php

namespace OmniaDigital\CatalystCore\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
