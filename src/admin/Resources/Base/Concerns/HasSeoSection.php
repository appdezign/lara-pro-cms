<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Filament\Forms\Components\TextInput;
use Lara\Admin\Components\TextAreaWithCounter;

trait HasSeoSection
{

	private static function getSeoSection(): array
	{

		$rows = array();

		$rows[] = TextInput::make('seo_title')
			->label(_q('lara-admin::default.column.seo_title'))
			->maxLength(300);

		$rows[] = TextAreaWithCounter::make('seo_description')
			->label(_q('lara-admin::default.column.seo_description'));

		$rows[] = TextAreaWithCounter::make('seo_keywords')
			->label(_q('lara-admin::default.column.seo_keywords'));

		return $rows;

	}

}