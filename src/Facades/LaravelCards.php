<?php

namespace DavideCasiraghi\LaravelCards\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DavideCasiraghi\LaravelCards\Skeleton\SkeletonClass
 */
class LaravelCards extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-cards';
    }
}
