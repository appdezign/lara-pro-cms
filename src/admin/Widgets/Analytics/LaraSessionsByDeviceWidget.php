<?php

namespace Lara\Admin\Widgets\Analytics;

use BezhanSalleh\GoogleAnalytics\Widgets\SessionsByDeviceWidget;

class LaraSessionsByDeviceWidget extends SessionsByDeviceWidget
{
    public ?string $filter = 'LSD';

    protected static ?int $sort = 2;

	protected int | string | array $columnSpan = 1;

	public static function canView(): bool {
		return true;
	}
}
