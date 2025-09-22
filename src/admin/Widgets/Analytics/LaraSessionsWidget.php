<?php

namespace Lara\Admin\Widgets\Analytics;

use BezhanSalleh\GoogleAnalytics\Widgets\SessionsWidget;

class LaraSessionsWidget extends SessionsWidget
{
    public ?string $filter = 'LSD';

    protected static ?int $sort = 5;

	protected int | string | array $columnSpan = 1;

	public static function canView(): bool {
		return true;
	}
}
