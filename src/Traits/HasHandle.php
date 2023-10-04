<?php

namespace OmniaDigital\CatalystCore\Traits;

trait HasHandle
{
    abstract public static function findByHandle($handle);
}
