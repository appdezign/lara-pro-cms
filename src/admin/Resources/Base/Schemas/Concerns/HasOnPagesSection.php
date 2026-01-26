<?php

namespace Lara\Admin\Resources\Base\Schemas\Concerns;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;

trait HasOnPagesSection
{
	private static function getOnPagesSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('is_global')
			->label(_q('lara-admin::default.column.is_global', true))
			->live();

		$rows[] = Fieldset::make('onpage_pages')
			->label(_q('lara-admin::default.fieldset.onpages', true))
			->schema([
				CheckboxList::make('onpages')
					->hiddenLabel()
					->relationship(
						titleAttribute: 'title',
						modifyQueryUsing: function ($query) {
							return $query->where('language', static::$clanguage)->whereIn('cgroup', ['page', 'module'])->orderby('cgroup', 'desc')->orderby('position');
						}
					)
					->disabled(fn(Get $get): bool => $get('is_global')),
			]);

		return $rows;

	}
}