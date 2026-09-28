<?php

namespace Lara\Common\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

/**
 * Shared route provider for the Lara modules (common, front, app).
 *
 * Each module registers its own web.php and api.php under its own controller
 * namespace; everything else about the three providers was identical.
 *
 * LoadsTranslatedCachedRoutes belongs here rather than on a single module.
 * When routes are cached, every RouteServiceProvider's register() calls
 * loadCachedRoutes(), and a compiled routes file replaces the entire route
 * collection - so the provider registered last is the one that decides which
 * cache file wins. Previously only the app provider loaded the locale-specific
 * file, and it worked purely because bootstrap/providers.php happens to list it
 * last. With the trait here, every module resolves the same locale-specific
 * file and registration order stops mattering.
 */
abstract class LaraModuleRouteProvider extends RouteServiceProvider
{
    use LoadsTranslatedCachedRoutes;

    /**
     * Controller namespace applied to this module's routes, and used as the
     * URL generator's root namespace.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Absolute path to the directory holding this module's route files.
     *
     * Implemented per module so that __DIR__ resolves to the module, not to
     * this base class.
     */
    abstract protected function routesPath(): string;

    /**
     * Called by RouteServiceProvider::loadRoutes() when routes are not cached.
     */
    public function map(): void
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Web routes: session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        $path = $this->routesPath().'/web.php';

        if (! file_exists($path)) {
            return;
        }

        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function () use ($path) {
            require $path;
        });
    }

    /**
     * API routes: stateless.
     */
    protected function mapApiRoutes(): void
    {
        $path = $this->routesPath().'/api.php';

        if (! file_exists($path)) {
            return;
        }

        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function () use ($path) {
            require $path;
        });
    }
}
