<?php

namespace Lara\Front\LaraTheme\Facade;

class LaraTheme extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return \Lara\Front\LaraTheme\Helpers\LaraThemeHelpers::class;
    }
}
