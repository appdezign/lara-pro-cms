<?php

namespace Lara\Admin\Providers;

use AchyutN\FilamentLogViewer\Contracts\LogProvider;
use AchyutN\FilamentLogViewer\Providers\LocalLogProvider;

class LaraLogProvider extends LocalLogProvider implements LogProvider
{
    protected function getAllLogFiles(): array
    {
        return ['laravel.log'];
    }
}
