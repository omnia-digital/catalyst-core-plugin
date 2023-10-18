<?php

namespace OmniaDigital\CatalystSocialPlugin\Traits;

trait HasHandle
{
    abstract public static function findByHandle($handle);
}
