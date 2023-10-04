<?php

namespace OmniaDigital\CatalystCore\Facades;

use Illuminate\Support\Facades\Facade;
use OmniaDigital\CatalystCore\Support\Translate;

class TranslateFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return Translate::class;
    }
}
