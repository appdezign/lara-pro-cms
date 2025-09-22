<?php

namespace Lara\Admin\Traits;

use Illuminate\Support\Facades\App;
use Lara\Admin\Enums\NavGroup;

trait HasNavGroup
{

	public static function getNavGroup($navGroup): ?string
	{
		$navigationGroup = NavGroup::from($navGroup);
		$locale = App::currentLocale();
		if ($locale == 'nl') {
			return $navigationGroup->getLabelNl();
		} else {
			return $navigationGroup->getLabelEn();
		}
	}

}
