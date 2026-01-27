<?php

namespace Lara\Admin\Resources\Base\Concerns;

trait HasTableQuery
{
	private static function getBaseQuery($query)
	{

		static::setContentLanguage();

		$query->langIs(static::$clanguage)
			->with('terms')
			->withCount('images')
			->withCount('files')
			->withCount('videos')
			->withCount('videofiles');

		return $query;

	}

	private static function getSortOrder($query)
	{
		if(static::getSecondarySortField() && static::getSecondarySortOrder()) {
			return $query
				->orderBy(static::getPrimarySortField(), static::getPrimarySortOrder())
				->orderBy(static::getSecondarySortField(), static::getSecondarySortOrder());
		} else {
			return $query
				->orderBy(static::getPrimarySortField(), static::getPrimarySortOrder());
		}
	}


}