<?php

namespace Lara\Front\Providers;

use Lara\Common\Providers\LaraModuleRouteProvider;

class LaraFrontRouteProvider extends LaraModuleRouteProvider
{
    /**
     * @var string
     */
    protected $namespace = 'Lara\Front\Http\Controllers';

    protected function routesPath(): string
    {
        return __DIR__.'/../Routes';
    }
}
