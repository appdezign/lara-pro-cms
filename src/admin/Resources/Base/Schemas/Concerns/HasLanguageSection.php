<?php

namespace Lara\Admin\Resources\Base\Schemas\Concerns;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Lara\Admin\Components\LanguageVersions;
use Lara\Common\Models\Entity;
use Lara\Common\Models\Language;

trait HasLanguageSection
{
	private static function getLanguageParentSection(): array
	{
		$rows = array();

		$rows[] = Select::make('language_parent')
			->label(_q('lara-admin::default.column.language_parent'))
			->options(function (Get $get) {
				$parents = null;
				$defaultLanguage = static::getDefaultLanguage();
				$entity = Entity::where('resource_slug', static::getSlug())->first();
				if ($entity) {
					$modelClass = $entity->model_class;
					$parents = $modelClass::langIs($defaultLanguage)->whereNot('language', $get('language'))->pluck('title', 'id')->toArray();
				}

				return $parents;
			});

		return $rows;
	}

	private static function getLanguageChildrenSection(): array
	{
		$rows = array();

		$rows[] = LanguageVersions::make('language_children')
			->label(_q('lara-admin::default.column.language_children'));

		return $rows;
	}

	private static function getDefaultLanguage(): string
	{
		return Language::where('default', 1)->pluck('code')->first();
	}
}