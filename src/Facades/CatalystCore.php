<?php

namespace OmniaDigital\CatalystCore\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OmniaDigital\CatalystCore\CatalystCore
 */
class CatalystCore extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OmniaDigital\CatalystCore\CatalystCore::class;
    }
}
