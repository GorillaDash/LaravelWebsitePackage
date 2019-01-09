<?php

namespace GorillaDash\LaravelWebsite\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelWebsiteFacade
 *
 * @package GorillaDash\LaravelWebsite\Facade
 */
class LaravelWebsiteFacade extends Facade
{
    /**
     * @see \GorillaDash\LaravelWebsite\GorillaDash
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelwebsite';
    }
}
