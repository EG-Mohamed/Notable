<?php

namespace MohamedSaid\Notable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MohamedSaid\Notable\Notable
 */
class Notable extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MohamedSaid\Notable\Notable::class;
    }
}
