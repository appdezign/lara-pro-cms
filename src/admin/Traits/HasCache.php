<?php

namespace Lara\Admin\Traits;

trait HasCache
{

	public static function clearCacheTypes(array $types = [], $force = true): bool
	{
		if ($force) {

			$types = [
				'app_cache',
				'config_cache',
				'view_cache',
				'response_cache',
				'route_cache',
			];

			session(['laracacheclear' => $types]);

			return true;

		} else {

			if (count($types) == 0) {

				return false;

			} else {

				session(['laracacheclear' => $types]);

				return true;

			}

		}

	}

}
