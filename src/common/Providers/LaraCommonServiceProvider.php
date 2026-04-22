<?php

namespace Lara\Common\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
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

use Awcodes\Curator\CuratorPlugin;
use Awcodes\Curator\Facades\Curator;
use Awcodes\Curator\Facades\Glide;
use Awcodes\Curator\Models\Media;

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

		// Merge config
		$this->mergeConfigFrom(__DIR__ . '/../../../config/lara.php', 'lara');
		$this->mergeConfigFrom(__DIR__ . '/../../../config/lara-common.php', 'lara-common');

		// Publish Config
		$this->publishes([
			__DIR__ . '/../../../config/lara.php' => config_path('lara.php'),
			__DIR__ . '/../../../config/lara-common.php' => config_path('lara-common.php'),
		], 'lara');

		// Load Views
		$this->loadViewsFrom(__DIR__.'/../../../resources/views/common', 'lara-common');

		// Load Translations
		$this->loadTranslationsFrom(app()->langPath() . '/vendor/lara-common', 'lara-common');

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

		Gate::policy(Models\Cta::class, Policies\CtaPolicy::class);
		Gate::policy(Models\Entity::class, Policies\EntityPolicy::class);
		Gate::policy(Models\Menu::class, Policies\MenuPolicy::class);
		Gate::policy(Models\MenuItem::class, Policies\MenuItemPolicy::class);
		Gate::policy(Models\Page::class, Policies\PagePolicy::class);
		Gate::policy(Models\Setting::class, Policies\SettingPolicy::class);
		Gate::policy(Models\Translation::class, Policies\TranslationPolicy::class);
		Gate::policy(Models\Translation::class, Policies\TranslationPolicy::class);
		Gate::policy(Models\LaraWidget::class, Policies\WidgetPolicy::class);

		// 3rd party libraries
		Gate::policy(Role::class, Policies\RolePolicy::class);
		Gate::policy(Media::class, Policies\MediaPolicy::class);

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
		// set media path for Glide (awcodes/curator)
		Glide::basePath('glide');

		// Curator settings for Media Resource
		Curator::imageResizeMode(config('lara.uploads.images.resize_mode', 'contain'));
		Curator::imageResizeTargetWidth(config('lara.uploads.images.max_width', 1920));
		Curator::imageResizeTargetHeight(config('lara.uploads.images.max_height', 1920));

	}
}
