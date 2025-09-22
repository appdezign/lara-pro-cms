<?php

namespace Lara\Admin\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Lara\Admin\Livewire\ClearCache;
use Lara\Admin\Livewire\LaraEntityReorder;
use Lara\Admin\Livewire\LaraMenuReorder;
use Lara\Admin\Livewire\LaraTagReorder;
use Lara\Admin\Widgets\Analytics;
use Livewire\Livewire;

class LaraAdminServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the module services.
	 *
	 * @return void
	 */
	public function boot()
	{

		// Load Translations
		$this->loadTranslationsFrom(__DIR__ . '/../../../resources/lang/admin', 'lara-admin');

		// Publish Views
		$this->publishes([
			__DIR__.'/../../../resources/views/admin' => resource_path('views/vendor/lara-admin'),
		], 'laraviews');
		$this->loadViewsFrom(__DIR__.'/../../../resources/views/admin', 'lara-admin');

		// Implicitly grant "Super Admin" role all permissions
		// This works in the app by using gate-related functions like auth()->user->can() and @can()
		Gate::before(function ($user, $ability) {
			return $user->hasRole('superadmin') ? true : null;
		});

		// register namespaced Livewire Components
		Livewire::component('clear-cache', ClearCache::class);
		Livewire::component('lara-menu-reorder', LaraMenuReorder::class);
		Livewire::component('lara-tag-reorder-nested', LaraTagReorder::class);
		Livewire::component('lara-tag-reorder-list', LaraTagReorder::class);
		Livewire::component('lara-entity-reorder', LaraEntityReorder::class);

		// GA4 Widgets
		Livewire::component('lara-active-users-seven-day-widget', Analytics\LaraActiveUsersSevenDayWidget::class);
		Livewire::component('lara-active-users-twenty-eight-day-widget', Analytics\LaraActiveUsersTwentyEightDayWidget::class);
		Livewire::component('lara-most-visited-pages-widget', Analytics\LaraMostVisitedPagesWidget::class);
		Livewire::component('lara-page-views-widget', Analytics\LaraPageViewsWidget::class);
		Livewire::component('lara-sessions-by-country-widget', Analytics\LaraSessionsDurationWidget::class);
		Livewire::component('lara-sessions-by-device-widget', Analytics\LaraSessionsByDeviceWidget::class);
		Livewire::component('lara-sessions-duration-widget', Analytics\LaraSessionsByCountryWidget::class);
		Livewire::component('lara-sessions-widget', Analytics\LaraSessionsWidget::class);
		Livewire::component('Lara-top-referrers-list-widget', Analytics\LaraTopReferrersListWidget::class);
		Livewire::component('lara-visitors-widget', Analytics\LaraVisitorsWidget::class);




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
