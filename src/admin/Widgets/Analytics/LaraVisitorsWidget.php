<?php

namespace Lara\Admin\Widgets\Analytics;

use BezhanSalleh\GoogleAnalytics\Widgets\VisitorsWidget;

class LaraVisitorsWidget extends VisitorsWidget
{
    public ?string $filter = 'LSD';

    protected static ?int $sort = 4;

	protected int | string | array $columnSpan = 1;

	public static function canView(): bool {
		return true;
	}

}
