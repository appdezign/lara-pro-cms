<?php

namespace Lara\Admin\Traits;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

trait HasCache
{

	public static function clearCacheTypes(array $types = [], $force = true): bool
	{
		if ($force) {

			/*
			File::delete(base_path('bootstrap/cache/config.php'));
			File::cleanDirectory(storage_path('framework/cache/data'));
			File::cleanDirectory(storage_path('framework/views'));
			File::cleanDirectory(storage_path('httpcache'));
			*/

			$types = [
				'app_cache',
				'config_cache',
				'view_cache',
				'http_cache',
				'route_cache',
			];

			session()->push('laracacheclear', $types);

			return true;

		} else {

			if (count($types) == 0) {
				return false;
			} else {

				/*
				if (in_array('app_cache', $types)) {
					File::cleanDirectory(storage_path('framework/cache/data'));
				}

				if (in_array('config_cache', $types)) {
					File::delete(base_path('bootstrap/cache/config.php'));
				}

				if (in_array('view_cache', $types)) {
					File::cleanDirectory(storage_path('framework/views'));
				}

				if (in_array('http_cache', $types)) {
					File::cleanDirectory(storage_path('httpcache'));
				}

				if (in_array('route_cache', $types)) {
					// session(['laracacheclear' => true]);
				}
				*/

				session()->push('laracacheclear', $types);

				return true;

			}

		}

	}

}
