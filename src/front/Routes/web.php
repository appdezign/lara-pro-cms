<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\App;

use Lara\Common\Models\MenuItem;
use Lara\Common\Models\Redirect;
use Lara\Common\Models\Entity;

if (!App::runningInConsole() && !config('lara.needs_setup')) {

	Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['web', 'httpcache', 'throttle:60,1', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'dateLocale']], function () {

		$locale = LaravelLocalization::getCurrentLocale();

		// get home
		$rootMenuItem = MenuItem::langIs($locale)
			->menuSlugIs('main')
			->whereNull('parent_id')
			->with('entity')
			->first();

		if ($rootMenuItem) {

			/* ~~~~~~~~~~~~ DYNAMIC ROUTE MIDDLEWARE (start) ~~~~~~~~~~~~ */
			$specialMiddleware = array();
			if ((isset($rootMenuItem->entity) && $rootMenuItem->entity->has_front_auth) == 1 || $rootMenuItem->route_has_auth) {
				$specialMiddleware[] = 'auth';
			}
			if (config('app.env') == 'production' && config('httpcache.enabled')) {
				$specialMiddleware[] = 'ttl:' . config('lara.httpcache_ttl');
			}
			/* ~~~~~~~~~~~~ DYNAMIC ROUTE MIDDLEWARE (end) ~~~~~~~~~~~~ */

			// Search
			Route::get('search', 'Special\SearchController@form')->name('special.search.form')->middleware($specialMiddleware);
			Route::get('searchresult', 'Special\SearchController@result')->name('special.search.result')->middleware($specialMiddleware);

			Route::get('searchresult/{module}', 'Special\SearchController@modresult')->name('special.search.modresult')->middleware($specialMiddleware);

		}

		// debug, use for console command (artisan)
		// $locale = 'nl';
		$locale = LaravelLocalization::getCurrentLocale();

		/**
		 * Get all FOLDERS from the MENU
		 * and create redirects
		 */
		$menuFolders = MenuItem::langIs($locale)
			->typeIs('parent')
			->get();

		foreach ($menuFolders as $menuFolder) {

			if (!empty($menuFolder->route)) {

				$child = $menuFolder->descendants()->defaultOrder()->first();

				if (!empty($child)) {

					$childroute = str_replace('/', '|', $child->route);
					$childroutename = 'special.redirect.' . $childroute;

					Route::get($menuFolder->route, 'Special\FrontRedirectorController@process')
						->name($childroutename);

				} else {

					Route::get($menuFolder->route, 'Special\FrontRedirectorController@redirectHome');

				}

			}
		}

		// 404
		// Route::get('/{route}', 'Error\ErrorController@show')->name('error.show.404');

		// redirects
		/* TODO: Redirects
		$redirects = Redirect::langIs($locale)->isPublished()->where('has_error', 0)->get();

		foreach ($redirects as $redirect) {
			$from = $redirect->redirectfrom;
			$to = $redirect->redirectto;
			$check = MenuItem::langIs($locale)->where('route', $from)->first();
			if ($check) {
				// ignore redirect
				$redirect->has_error = 1;
				$redirect->save();
			} else {
				Route::get($from, 'Special\FrontRedirectorController@process')
					->name($to);
			}
		}
		*/

	});

	// API for Pages and Blocks
	Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

		Route::group(['prefix' => 'api', 'middleware' => 'auth:api'], function () {

			Route::resource('page', 'Api\\Page\\PagesController', ['as' => 'api', 'parameters' => ['page' => 'id']])->only(['index', 'show']);

			$entities = Entity::where('cgroup', 'block')->get();
			foreach ($entities as $entity) {
				Route::resource($entity->resource_slug, 'Api\\Blocks\\' . $entity->controller, ['as' => 'api', 'parameters' => ['page' => 'id']])->only(['index', 'show']);
			}

		});

	});

	// get CSRF token without HttpCache
	Route::get('csrf/{type}', '\Lara\Front\Http\Controllers\Special\CsrfController@show')->name('front.csrf');

	// get User IP without HttpCache
	Route::get('usrip/{type}', '\Lara\Front\Http\Controllers\Special\UsripController@show')->name('front.usrip');

	// get Login Widget without HttpCache
	Route::get('loginwidget/{type}', '\Lara\Front\Http\Controllers\Special\LoginwidgetController@show')->name('front.loginwidget');

	// Frontend Uploaders
	Route::post('upload/{type}', '\Lara\Front\Http\Controllers\Special\UploadController@process')->name('front.upload');

	Route::post('upload2/{type}', '\Lara\Front\Http\Controllers\Special\Upload2Controller@process')->name('front.upload2');

}
