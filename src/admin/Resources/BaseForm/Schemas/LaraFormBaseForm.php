<?php

namespace Lara\Admin\Resources\BaseForm\Schemas;

use Cache;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Lara\Admin\Enums\EntityHook;

use Lara\Admin\Resources\Base\Concerns\HasBaseForm;

trait LaraFormBaseForm
{

	use HasBaseForm;

	private static function getLaraFormTabs(): array
	{

		$tabs = array();

		$tabs[] = Tab::make(_q('lara-admin::default.tabs.content', true))
			->schema(static::getContentSections());

		return $tabs;

	}

	private static function getContentSections(): array
	{
		$sections = array();

		$sections[] = Section::make(_q('lara-admin::default.section.content', true))
			->collapsible()
			->schema(static::getContentSection());

		return $sections;
	}


	private static function getContentSection(): array
	{

		static::setContentLanguage();

		$rows = array();

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::DEFAULT->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		return $rows;

	}

}
