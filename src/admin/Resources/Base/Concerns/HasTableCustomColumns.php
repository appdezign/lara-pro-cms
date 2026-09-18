<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Cache;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Lara\Admin\Enums\CustomFieldType;
use Lara\Common\Entities\EntityRegistry;

trait HasTableCustomColumns
{
	private static function getCustomColumnsByHook($hook)
	{
		$cacheKey = 'lara_entity_table_custom_fields_' . static::getSlug() . '_' . $hook
			. '_' . app(EntityRegistry::class)->version();

		return Cache::rememberForever($cacheKey, function () use ($hook) {
			return static::getEntity()->customfields()->where('field_hook', $hook)->where('show_in_list', 1)->get();
		});
	}

	private static function getCustomDateColumn()
	{
		$cacheKey = 'lara_entity_custom_date_field_' . static::getSlug()
			. '_' . app(EntityRegistry::class)->version();

		return Cache::rememberForever($cacheKey, function () {
			return static::getEntity()->customfields()
				->whereIn('field_type', ['date', 'datetime'])
				->where('show_in_list', 1)
				->orderBy('sort_order', 'asc')
				->first();
		});
	}

	private static function getFilamentColumn($field)
	{

		$booleanTypes = [
			CustomFieldType::Checkbox->value,
			CustomFieldType::Toggle->value,
		];

		$arrayTypes = [
			CustomFieldType::CheckboxList->value,
			CustomFieldType::ToggleButtons->value,
			CustomFieldType::TagsInput->value,
			CustomFieldType::MultiSelect->value,
		];

		if (in_array($field->field_type, $booleanTypes)) {

			return IconColumn::make($field->field_name)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.column.' . $field->field_name))
				->width('5%')
				->toggleable()
				->boolean()
				->trueIcon('bi-check2-circle')
				->falseIcon(false)
				->size('md')
				->visibleFrom('xl');

		} elseif (in_array($field->field_type, $arrayTypes)) {
			//
		} else {

			return TextColumn::make($field->field_name)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.column.' . $field->field_name))
				->toggleable()
				->visibleFrom('xl');

		}

	}


}