<?php

namespace OmniaDigital\CatalystCore\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OmniaDigital\CatalystCore\Catalyst
 */
class Catalyst extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OmniaDigital\CatalystCore\Catalyst::class;
    }
}
