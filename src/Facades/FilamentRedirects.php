<?php

namespace Vormkracht10\FilamentRedirects\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vormkracht10\FilamentRedirects\FilamentRedirects
 */
class FilamentRedirects extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vormkracht10\FilamentRedirects\FilamentRedirects::class;
    }
}
