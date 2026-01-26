<?php

namespace Lara\Admin\Resources\Base\Schemas\Concerns;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Lara\Admin\Components\TextAreaWithCounter;

trait HasOpenGraphSection
{
	private static function getOpenGraphSection(): array
	{
		$rows = array();

		$rows[] = ViewField::make('opengraphview')
			->view('lara-admin::partials.opengraph');

		return $rows;
	}
	private static function getOpenGraphAdvancedSection(): array
	{

		$rows = array();

		$rows[] = TextInput::make('og_title')
			->label(_q('lara-admin::default.column.og_title'))
			->maxLength(300);

		$rows[] = TextAreaWithCounter::make('og_description')
			->label(_q('lara-admin::default.column.og_description'));

		$rows[] = CuratorPicker::make('og_image')
			->label('OG Image')
			->inlineLabel()
			->directory(static::getSlug());

		return $rows;

	}
}