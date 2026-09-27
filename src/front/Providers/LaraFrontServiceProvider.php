<?php

namespace Lara\Front\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Lara\Common\Http\Controllers\Setup\Concerns\HasSetup;
use Lara\Front\Http\Concerns\HasFrontend;
use Lara\Front\Http\Concerns\HasTheme;
use Lara\Front\LaraTheme\Theme;
use Lara\Front\LaraTheme\ThemeViewFinder;
use Lara\Front\View\Components\FrontFormRowComponent;
use Lara\Front\View\Components\FrontShowRowComponent;

class LaraFrontServiceProvider extends ServiceProvider
{
	use HasFrontend;
	use HasSetup;
	use HasTheme;

	/**
	 * Bootstrap the module services.
	 *
	 * @return void
	 */
	public function boot()
	{

		// Publish Config
		$this->publishes([
			__DIR__.'/../../../config/lara-front.php' => config_path('lara-front.php'),
		], 'lara');

		// Publish Views
		$this->loadViewsFrom(__DIR__.'/../../../resources/views/front', 'lara-front');

		// Load Translations
		$this->loadTranslationsFrom(app()->langPath().'/vendor/lara-front', 'lara-front');

		// register components
		Blade::component('frontformrow', FrontFormRowComponent::class);
		Blade::component('frontshowrow', FrontShowRowComponent::class);

		// Frontend only.
		//
		// runningInConsole() is true under PHPUnit as well as under artisan,
		// because both run on the CLI SAPI. Tests that simulate a frontend
		// request do need the theme and the shared settings, so they are
		// distinguished with runningUnitTests().
		$isServingRequest = ! App::runningInConsole() || App::runningUnitTests();

		if ($isServingRequest && ! $this->app->request->is('admin/*')) {

			// Set theme
			$theme = $this->getFrontTheme();
			$parent = $this->getParentTheme();

			Theme::set($theme, $parent);

		}

	}

	/**
	 * Register the module services.
	 *
	 * @return void
	 */
	public function register()
	{

		// Merge config
		$this->mergeConfigFrom(__DIR__.'/../../../config/lara-front.php', 'lara-front');

		$this->app->register(LaraFrontRouteProvider::class);

		$this->registerThemeFinder();

		// register facade alias, so we can use it in templates
		$this->app->booting(function () {
			$loader = AliasLoader::getInstance();
			$loader->alias('Theme', '\Lara\Front\LaraTheme\Facade\LaraTheme');
		});

	}

	protected function registerThemeFinder(): void
	{
		$this->app->singleton('theme.finder', function ($app) {
			$themeFinder = new ThemeViewFinder(
				$app['files'],
				$app['config']['view.paths']
			);

			$themeFinder->setHints(
				$this->app->make('view')->getFinder()->getHints()
			);

			return $themeFinder;
		});

	}
}
