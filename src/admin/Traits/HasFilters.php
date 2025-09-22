<?php

namespace Lara\Admin\Traits;

trait HasFilters
{

	private static function getActiveFilterFromPage($pageClass, $filterName, $defaultValue = null): ?string
	{
		$filter = $defaultValue;
		$table = md5($pageClass);
		if(session()->has('tables')) {
			$tableFilters = session()->get('tables');
			$sessionKey = "{$table}_filters";
			if(key_exists($sessionKey, session()->get('tables'))) {
				$activeFilter = $tableFilters[$sessionKey];
				if ($activeFilter) {
					$value = $activeFilter[$filterName]['value'];
					if(!empty($value)) {
						$filter = $value;
					}
				}
			}
		}
		return $filter;
	}
}
