<?php

namespace Lara\Admin\Widgets\Analytics;

use BezhanSalleh\GoogleAnalytics\Widgets\SessionsByCountryWidget;

class LaraSessionsDurationWidget extends SessionsByCountryWidget
{
    public ?string $filter = 'LSD';

    protected static ?int $sort = 6;

	protected int | string | array $columnSpan = 1;

	public static function canView(): bool {
		return true;
	}
}
