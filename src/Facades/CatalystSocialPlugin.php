<?php

namespace OmniaDigital\CatalystCore\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OmniaDigital\CatalystCore\CatalystSocialPlugin
 */
class CatalystSocialPlugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OmniaDigital\CatalystCore\CatalystSocialPlugin::class;
    }
}
