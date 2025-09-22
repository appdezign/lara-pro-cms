<?php

namespace Lara\Admin\Widgets\Analytics;

use BezhanSalleh\GoogleAnalytics\Widgets\SessionsDurationWidget;

class LaraSessionsByCountryWidget extends SessionsDurationWidget
{

    public ?string $filter = 'LSD';

    protected static ?int $sort = 1;

	protected int | string | array $columnSpan = 1;

	public static function canView(): bool {
		return true;
	}

}
