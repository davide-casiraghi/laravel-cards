<?php

namespace DavideCasiraghi\LaravelCards;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DavideCasiraghi\LaravelCards\Skeleton\SkeletonClass
 */
class LaravelCardsFacade extends Facade
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
