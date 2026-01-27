<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Cache;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\Alignment;
use Lara\Common\Models\Entity;
use Lara\Common\Models\MenuItem;

trait HasRelatedSection
{
	private static function getRelatedSection(): array
	{

		$rows = array();

		$rows[] = Fieldset::make(_q('lara-admin::default.fieldset.related_page_objects', true))
			->schema([
				Repeater::make('related_page_objects')
					->label(_q('lara-admin::default.repeater.related_page_objects', true))
					->defaultItems(0)
					->addActionLabel(_q('lara-admin::default.repeater.add', true))
					->addActionAlignment(Alignment::Start)
					->schema([
						Select::make('page_object_id')
							->label(_q('lara-admin::default.repeaterfield.page', true))
							->options(function () {
								return MenuItem::where('type', 'page')->pluck('title', 'object_id')->toArray();
							}),
					])
					->columnSpanFull(),
			]);

		$rows[] = Fieldset::make(_q('lara-admin::default.fieldset.related_entity_objects', true))
			->schema([
				Repeater::make('related_entity_objects')
					->label(_q('lara-admin::default.repeater.related_entity_objects', true))
					->defaultItems(0)
					->addActionLabel(_q('lara-admin::default.repeater.add', true))
					->addActionAlignment(Alignment::Start)
					->schema([
						Select::make('resource_slug')
							->label(_q('lara-admin::default.repeaterfield.resource_slug', true))
							->live()
							->options(static::getRelatableEntities()),
						Select::make('object_id')
							->label(_q('lara-admin::default.repeaterfield.object_id', true))
							->options(function (Get $get) {
								$resource_slug = $get('resource_slug');
								if ($resource_slug) {
									$entity = Entity::where('resource_slug', $resource_slug)->first();
									if ($entity) {
										$modelClass = $entity->model_class;

										return $modelClass::langIs(static::$clanguage)->pluck('title', 'id')->toArray();
									}
								}
							}),
					])
					->columnSpanFull(),
			]);

		$rows[] = Fieldset::make(_q('lara-admin::default.fieldset.related_entities', true))
			->schema([
				Repeater::make('related_entities')
					->label(_q('lara-admin::default.repeater.related_entities', true))
					->defaultItems(0)
					->addActionLabel(_q('lara-admin::default.repeater.add', true))
					->addActionAlignment(Alignment::Start)
					->schema([
						Select::make('module_page_menu_id')
							->label(_q('lara-admin::default.repeaterfield.menu_item', true))
							->options(MenuItem::where('type', 'entity')->pluck('title', 'id')->toArray()),
					])
					->columnSpanFull(),
			]);

		return $rows;

	}

	private static function getRelatableEntities(): array
	{
		$cacheKey = 'lara_relatable_entities';

		return Cache::rememberForever($cacheKey, function () {
			return MenuItem::with('entity')
				->where('type', 'entity')
				->whereHas('entity', function ($query) {
					$query->where('objrel_is_relatable', 1);
				})
				->get()
				->pluck('entity.resource_slug', 'entity.resource_slug')->toArray();
		});
	}
}