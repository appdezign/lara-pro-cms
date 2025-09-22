<?php

namespace Lara\Admin\Resources\BaseForm\Tables;

use Cache;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Lara\Admin\Enums\CustomFieldType;
use Lara\Admin\Enums\FormHook;
use Lara\Common\Models\User;

trait LaraFormBaseTable
{

	private static function getBaseTableColumns(): array
	{

		$columns = array();

		$columns[] = TextColumn::make('id')
			->label(_q('lara-admin::default.column.id'))
			->width('5%')
			->numeric()
			->toggleable()
			->sortable();

		$columns[] = TextColumn::make('created_at')
			->label(_q('lara-admin::default.column.created_at'))
			->width('15%')
			->toggleable()
			->dateTime('j M Y')
			->sortable()
			->visibleFrom('2xl');

		foreach (static::getCustomColumnsByHook(FormHook::DEFAULT->value) as $customField) {
			if (!empty(static::getFilamentColumn($customField))) {
				$columns[] = static::getFilamentColumn($customField);
			}
		}

		// dd($columns);

		return $columns;
	}

	private static function getBaseTableFilters(): array
	{

		$filters = array();

		if (static::getEntity()->filter_by_trashed) {
			$filters[] = TrashedFilter::make();
		}

		return $filters;
	}

	private static function getBaseTableActions(): array
	{

		$actions = array();

		$actions[] = ViewAction::make()
				->label('');

		return $actions;
	}

	private static function getBaseTableBulkActions(): array
	{
		$actions = array();
		if (static::resourceShowBatch()) {
			$actions[] = BulkActionGroup::make([
				DeleteBulkAction::make(),
				ForceDeleteBulkAction::make(),
				RestoreBulkAction::make(),
			]);
		}

		return $actions;
	}

	private static function getBaseQuery($query)
	{

		$query->orderby(static::getPrimarySortField(), static::getPrimarySortOrder());

		return $query;

	}

	private static function getCustomColumnsByHook($hook)
	{
		$cacheKey = 'lara_entity_table_custom_fields_' . static::getSlug() . '_' . $hook;

		return Cache::rememberForever($cacheKey, function () use ($hook) {
			return static::getEntity()->customfields()->where('field_hook', $hook)->where('show_in_list', 1)->get();
		});
	}


	private static function getFilamentColumn($field)
	{

		$booleanTypes = [
			CustomFieldType::CHECKBOX->value,
			CustomFieldType::TOGGLE->value,
		];

		$arrayTypes = [
			CustomFieldType::CHECKBOX_LIST->value,
			CustomFieldType::TOGGLE_BUTTONS->value,
			CustomFieldType::TAGS_INPUT->value,
			CustomFieldType::MULTI_SELECT->value,
		];

		if (in_array($field->field_type, $booleanTypes)) {

			return IconColumn::make($field->field_name)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.column.' . $field->field_name))
				->width('5%')
				->toggleable()
				->boolean()
				->size('md');

		} elseif (in_array($field->field_type, $arrayTypes)) {
			//
		} else {

			return TextColumn::make($field->field_name)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.column.' . $field->field_name))
				->toggleable();

		}

	}

}
