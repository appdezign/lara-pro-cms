<?php

namespace Lara\Admin\Pages;


use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults;

class LaraHealthCheckResults extends HealthCheckResults
{

	protected string $view = 'lara-admin::pages.health-check-results';

	public static function getNavigationIcon(): string
	{
		return '';
	}

	public static function getNavigationLabel(): string
	{
		return 'Health';
	}
	public static function getNavigationGroup(): ?string
	{
		return 'Tools';
	}
}