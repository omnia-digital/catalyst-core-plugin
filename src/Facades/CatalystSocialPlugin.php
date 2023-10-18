<?php

namespace OmniaDigital\CatalystSocialPlugin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OmniaDigital\CatalystSocialPlugin\CatalystSocialPlugin
 */
class CatalystSocialPlugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OmniaDigital\CatalystSocialPlugin\CatalystSocialPlugin::class;
    }
}
