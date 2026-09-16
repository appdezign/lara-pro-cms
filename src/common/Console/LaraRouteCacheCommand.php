<?php

namespace Lara\Common\Console;

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

			$routes = $this->getFreshApplicationRoutesForLocale($locale);

			if (count($routes) == 0) {
				$this->discardPendingRouteCaches($pendingRouteCaches);
				$this->error("Your application doesn't have any routes.");

				return;
			}

			foreach ($routes as $route) {
				$route->prepareForSerialization();
			}

			$path = $this->makeLocaleRoutesPath($locale);
			$temporaryPath = $path . '.' . getmypid() . '.tmp';

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
	 * Remove the temporary route cache files left behind by an aborted run.
	 *
	 * @param array<string, string> $pendingRouteCaches
	 */
	protected function discardPendingRouteCaches(array $pendingRouteCaches): void
	{
		$this->files->delete(array_keys($pendingRouteCaches));
	}

}
