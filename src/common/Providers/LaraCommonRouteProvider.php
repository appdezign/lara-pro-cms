<?php

namespace Lara\Common\Providers;

class LaraCommonRouteProvider extends LaraModuleRouteProvider
{

	/**
	 * @var string
	 */
	protected $namespace = 'Lara\Common\Http\Controllers';

	protected function routesPath(): string
	{
		return __DIR__ . '/../Routes';
	}

}
