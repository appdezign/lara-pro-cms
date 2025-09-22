<?php

namespace Lara\Admin\Widgets\Analytics;

use BezhanSalleh\GoogleAnalytics\Widgets\MostVisitedPagesWidget;

class LaraMostVisitedPagesWidget extends MostVisitedPagesWidget
{
    public ?string $filter = 'TM';

    protected static ?int $sort = 7;

	protected int | string | array $columnSpan = 1;

	public static function canView(): bool {
		return true;
	}

}
