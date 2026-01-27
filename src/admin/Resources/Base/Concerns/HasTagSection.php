<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Filament\Forms\Components\CheckboxList;

trait HasTagSection
{
	private static function getTagSection(): array
	{
		$rows = array();

		$rows[] = CheckboxList::make('categories')
			->label('Categories')
			->allowHtml()
			->relationship(
				titleAttribute: 'title',
				modifyQueryUsing: function ($query) {
					return $query->where('language', static::$clanguage)->where('resource_slug', static::getSlug());
				}
			)
			->getOptionLabelFromRecordUsing(fn($record) => static::formatNestedTitleBasic($record->title, $record->depth));

		$rows[] = CheckboxList::make('tags')
			->label('Tags')
			->relationship(
				titleAttribute: 'title',
				modifyQueryUsing: function ($query) {
					return $query->where('language', static::$clanguage)->where('resource_slug', static::getSlug());
				}
			);

		return $rows;
	}

}