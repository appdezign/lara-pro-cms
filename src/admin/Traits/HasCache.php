<?php

namespace Lara\Admin\Traits;

use Illuminate\Support\Facades\File;

trait HasCache
{

	public static function clearCacheTypes(array $types = [], $force = true): bool
	{
		if ($force) {

			File::cleanDirectory(storage_path('framework/cache/data'));
			File::delete(base_path('bootstrap/cache/config.php'));
			File::cleanDirectory(storage_path('framework/views'));
			File::cleanDirectory(storage_path('httpcache'));
			File::cleanDirectory(storage_path('imgcache'));

			return true;

		} else {

			if (count($types) == 0) {
				return false;
			} else {

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

				if (in_array('image_cache', $types)) {
					File::cleanDirectory(storage_path('imgcache'));
				}

				if (in_array('route_cache', $types)) {
					File::delete(base_path('bootstrap/cache/routes-v7.php'));
				}

				return true;
			}

		}

	}

}
