<?php

namespace Lara\Front\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

use Lara\Front\View\Components\FrontFormRowComponent;
use Lara\Front\View\Components\FrontShowRowComponent;

use Lara\Front\Http\Concerns\HasFrontend;
use Lara\Front\Http\Concerns\HasTheme;
use Lara\Common\Http\Controllers\Setup\Concerns\HasSetup;

use Lara\Common\Models\Setting;

use LaravelLocalization;

// use Theme;
use Qirolab\Theme\Theme;

class LaraFrontServiceProvider extends ServiceProvider
{

	use HasFrontend;
	use HasTheme;
	use HasSetup;

	/**
	 * Bootstrap the module services.
	 *
	 * @return void
	 */
	public function boot()
	{

		// Merge config
		$this->mergeConfigFrom(__DIR__ . '/../../../config/lara-front.php', 'lara-front');

		// Publish Config
		$this->publishes([
			__DIR__ . '/../../../config/lara-front.php' => config_path('lara-front.php'),
		], 'lara');

		// Publish Views
		$this->loadViewsFrom(__DIR__.'/../../../resources/views/front', 'lara-front');

		// Load Translations
		$this->loadTranslationsFrom(app()->langPath() . '/vendor/lara-front', 'lara-front');

		// register components
		Blade::component('frontformrow', FrontFormRowComponent::class);
		Blade::component('frontshowrow', FrontShowRowComponent::class);

		// Frontend only
		if (!App::runningInConsole() && !$this->app->request->is('admin/*')) {

			// Set theme
			$theme = $this->getFrontTheme();
			$parent = $this->getParentTheme();

			Theme::set($theme, $parent);

			if (!$this->laraNeedsSetup()) {

				// Share the settings with all views
				$settings = Setting::pluck('value', 'key')->toArray();
				$settingz = json_decode(json_encode($settings), false);
				View::share('settngz', $settingz);

			}

			// get Lara Version
			$laraversion = $this->getFrontLaraVersion();
			View::share('laraversion', $laraversion);

		}

	}

	/**
	 * Register the module services.
	 *
	 * @return void
	 */
	public function register()
	{

		$configPath = __DIR__ . '/../../../config/lara-front.php';
		$this->mergeConfigFrom($configPath, 'lara-front');

		$this->app->register(LaraFrontRouteProvider::class);

	}

}
