<?php

namespace Lara\Common\Providers;

use Barryvdh\HttpCache\Middleware\CacheRequests;
use Barryvdh\HttpCache\Middleware\SetTtl;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

use Lara\Common\Http\Middleware\DateLocale;
use Lara\Common\Http\Middleware\Force2fa;
use Lara\Common\Http\Middleware\HasBackendAccess;
use Lara\Common\Http\Middleware\UserLocale;
use Lara\Common\Models;
use Lara\Common\Models\Entity;
use Lara\Common\Policies;

use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use PragmaRX\Google2FALaravel\Middleware;
use Spatie\Permission\Models\Role;

use Lara\Common\Http\Controllers\Setup\Concerns\HasSetup;


class LaraCommonServiceProvider extends ServiceProvider
{

	use HasSetup;

	/**
	 * Bootstrap the module services.
	 *
	 * @return void
	 */
	public function boot(\Illuminate\Routing\Router $router)
	{

		// register global middleware
		$router->aliasMiddleware('userLocale', UserLocale::class);
		$router->aliasMiddleware('dateLocale', DateLocale::class);

		// $router->aliasMiddleware('lara2fa', Middleware::class);
		// $router->aliasMiddleware('force2fa', Force2fa::class);

		$router->aliasMiddleware('localize', LaravelLocalizationRoutes::class);
		$router->aliasMiddleware('localizationRedirect', LaravelLocalizationRedirectFilter::class);
		$router->aliasMiddleware('localeSessionRedirect', LocaleSessionRedirect::class);
		$router->aliasMiddleware('localeViewPath', LaravelLocalizationViewPath::class);

		// $router->aliasMiddleware('setTheme', setTheme::class);

		$router->aliasMiddleware('httpcache', CacheRequests::class);
		$router->aliasMiddleware('ttl', SetTtl::class);

		Gate::policy(Models\Entity::class, Policies\EntityPolicy::class);
		Gate::policy(Models\Menu::class, Policies\MenuPolicy::class);
		Gate::policy(Models\MenuItem::class, Policies\MenuItemPolicy::class);
		Gate::policy(Models\Page::class, Policies\PagePolicy::class);
		Gate::policy(Models\Setting::class, Policies\SettingPolicy::class);
		Gate::policy(Models\Translation::class, Policies\TranslationPolicy::class);
		Gate::policy(Models\User::class, Policies\UserPolicy::class);

		// 3rd party libraries
		Gate::policy(Role::class, Policies\RolePolicy::class);


		// Publish Views
		$this->publishes([
			__DIR__.'/../../../resources/views/common' => resource_path('views/vendor/lara-common'),
		], 'laraviews');
		$this->loadViewsFrom(__DIR__.'/../../../resources/views/common', 'lara-common');

		/**
		 * Override Image cache directories
		 */
		if (!$this->laraNeedsSetup() && !App::runningInConsole()) {

			$paths = array();
			$entities = Entity::get();

			foreach ($entities as $entity) {

				$path = Storage::disk('public')->path($entity->resource_slug);

				// check if directory exists
				if (!is_dir($path)) {
					// create media directory for this entity
					mkdir($path);
				}
				// add path to array
				$paths[] = $path;
			}

			config(['lara-image-cache.paths' => $paths]);

		}


	}

	/**
	 * Register the module services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
