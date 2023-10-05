<?php

namespace OmniaDigital\CatalystCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Traits\Schedulable;

class TeamNotification extends Model
{
    use HasFactory;
    use Schedulable;

    protected $guarded = [];

    /* protected static function newFactory()
    {
        return \Modules\Social\Database\factories\TeamNotificationFactory::new();
    } */
}
