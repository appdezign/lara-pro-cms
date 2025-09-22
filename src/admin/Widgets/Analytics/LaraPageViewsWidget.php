<?php

namespace Lara\Admin\Widgets\Analytics;

use BezhanSalleh\GoogleAnalytics\Widgets\PageViewsWidget;

class LaraPageViewsWidget extends PageViewsWidget
{
    public ?string $filter = 'LSD';

    protected static ?int $sort = 3;

	protected int | string | array $columnSpan = 1;

	public static function canView(): bool {
		return true;
	}

}
