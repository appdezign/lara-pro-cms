<?php

namespace Lara\Admin\Widgets\Analytics;

use BezhanSalleh\GoogleAnalytics\Widgets\TopReferrersListWidget;

class LaraTopReferrersListWidget extends TopReferrersListWidget
{
    public ?string $filter = 'TM';

    protected static ?int $sort = 8;

	protected int | string | array $columnSpan = 1;

	public static function canView(): bool {
		return true;
	}
}
