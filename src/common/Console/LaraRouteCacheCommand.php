<?php

namespace Lara\Common\Console;

use Illuminate\Routing\RouteCollection;
use Mcamara\LaravelLocalization\Commands\RouteTranslationsCacheCommand;

/**
 * Atomic drop-in replacement for 'route:trans:cache'.
 *
 * The parent command runs 'route:trans:clear' before it starts building, which leaves
 * bootstrap/cache/routes-v7.php missing for the duration of the rebuild. Any request
 * that already resolved Application::routesAreCached() to true (the result is memoized
 * in the container) then fatals on the deferred require in loadCachedRoutes().
 *
 * This version builds every locale into a temporary file first and only then renames
 * those over the live cache files, so a cached route file is never absent.
 *
 * Because the live cache stays in place, the fresh application that reads the routes of a
 * locale has to be told not to load it - otherwise it would load the previous cache and this
 * command would store the old routes again. See getFreshRoutesIgnoringCache().
 */
class LaraRouteCacheCommand extends RouteTranslationsCacheCommand
{
    /**
     * @var string
     */
    protected $name = 'lara:route:cache';

    /**
     * @var string
     */
    protected $description = 'Create a route cache file for all locales, without removing the current cache';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->cacheRoutesPerLocale();
    }

    /**
     * Build the route cache of every locale, then swap them in atomically.
     */
    protected function cacheRoutesPerLocale(): void
    {
        $allLocales = $this->getSupportedLocales();

        // a null locale builds the default cache, which is the file the
        // Application checks to decide whether routes are cached at all
        array_push($allLocales, null);

        /**
         * Temporary path => final path
         *
         * @var array<string, string> $pendingRouteCaches
         */
        $pendingRouteCaches = [];

        foreach ($allLocales as $locale) {

            // resolved before the routes are read, which points the cache path elsewhere
            $path = $this->makeLocaleRoutesPath($locale);

            $routes = $this->getFreshRoutesIgnoringCache($locale);

            if (count($routes) == 0) {
                $this->discardPendingRouteCaches($pendingRouteCaches);
                $this->error("Your application doesn't have any routes.");

                return;
            }

            foreach ($routes as $route) {
                $route->prepareForSerialization();
            }

            $temporaryPath = $path.'.'.getmypid().'.tmp';

            $this->files->put($temporaryPath, $this->buildRouteCacheFile($routes));

            $pendingRouteCaches[$temporaryPath] = $path;

        }

        foreach ($pendingRouteCaches as $temporaryPath => $path) {
            // rename() is atomic within the same filesystem, so a booting request
            // always sees either the previous cache or the new one, never nothing
            $this->files->move($temporaryPath, $path);
        }

        $this->info('Routes cached successfully for all locales!');

    }

    /**
     * The routes of a locale, read from the route files even while a route cache exists.
     *
     * The fresh application loads cached routes when it finds them, so while it boots, its
     * route cache path points to a file that does not exist.
     */
    protected function getFreshRoutesIgnoringCache(?string $locale): RouteCollection
    {
        $previous = $this->swapRoutesCachePath(storage_path('framework/lara-route-cache-build-'.getmypid().'.php'));

        try {
            return $this->getFreshApplicationRoutesForLocale($locale);
        } finally {
            $this->swapRoutesCachePath($previous);
        }
    }

    /**
     * Set APP_ROUTES_CACHE everywhere Laravel reads it from ($_SERVER first, then $_ENV and
     * getenv), so the value also wins over one set by the shell. Null removes it.
     *
     * @return string|null the previous value
     */
    protected function swapRoutesCachePath(?string $path): ?string
    {
        $previous = $_SERVER['APP_ROUTES_CACHE'] ?? $_ENV['APP_ROUTES_CACHE'] ?? (getenv('APP_ROUTES_CACHE') ?: null);

        if ($path === null) {
            unset($_SERVER['APP_ROUTES_CACHE'], $_ENV['APP_ROUTES_CACHE']);
            putenv('APP_ROUTES_CACHE');
        } else {
            $_SERVER['APP_ROUTES_CACHE'] = $_ENV['APP_ROUTES_CACHE'] = $path;
            putenv('APP_ROUTES_CACHE='.$path);
        }

        return $previous;
    }

    /**
     * Remove the temporary route cache files left behind by an aborted run.
     *
     * @param  array<string, string>  $pendingRouteCaches
     */
    protected function discardPendingRouteCaches(array $pendingRouteCaches): void
    {
        $this->files->delete(array_keys($pendingRouteCaches));
    }
}
