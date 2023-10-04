<?php

namespace OmniaDigital\CatalystCore\Facades;

use Illuminate\Support\Facades\Facade;

class Translate extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \OmniaDigital\CatalystCore\Support\Translate::class;
    }
}
