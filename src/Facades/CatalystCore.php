<?php

namespace OmniaDigital\CatalystCore\Facades;

use Illuminate\Support\Facades\Facade;
use OmniaDigital\CatalystCore\Catalyst;

/**
 * @see \OmniaDigital\CatalystCore\CatalystCore
 */
class CatalystCore extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Catalyst::class;
    }
}
