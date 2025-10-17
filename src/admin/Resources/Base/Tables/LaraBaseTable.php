<?php

namespace Lara\Admin\Resources\Base\Tables;

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
use Lara\Admin\Enums\EntityHook;
use Lara\Common\Models\User;

trait LaraBaseTable
{

	private static function getBaseTableColumns(): array
	{

		$columns = array();

		if (static::getEntity()->show_batch == 0) {
			$columns[] = TextColumn::make('id')
				->label(_q('lara-admin::default.column.id'))
				->width('5%')
				->numeric()
				->toggleable()
				->sortable()
				->visibleFrom('xl');
		}

		$columns[] = IconColumn::make('publish')
			->label(_q('lara-admin::default.column.publish'))
			->width('5%')
			->toggleable()
			->boolean()
			->trueIcon('bi-check2-circle')
			->falseIcon('bi-x-circle')
			->size('sm')
			->visibleFrom('md');

		$customDateColumn = static::getCustomDateColumn();
		if ($customDateColumn) {
			$columns[] = TextColumn::make($customDateColumn->field_name)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.column.' . $customDateColumn->field_name))
				->width('15%')
				->toggleable()
				->dateTime('j M Y')
				->sortable()
				->visibleFrom('2xl');
		} else {
			$columns[] = TextColumn::make('publish_from')
				->label(_q('lara-admin::default.column.publish_from'))
				->width('15%')
				->toggleable()
				->dateTime('j M Y')
				->sortable()
				->visibleFrom('2xl');
		}

		foreach (static::getCustomColumnsByHook(EntityHook::BEFORE_TITLE->value) as $customField) {
			if (!empty(static::getFilamentColumn($customField))) {
				$columns[] = static::getFilamentColumn($customField);
			}
		}

		$columns[] = TextColumn::make('title')
			->label(_q(static::getModule() . '::' . static::getSlug() . '.column.title'))
			->width('40%')
			->sortable()
			->searchable();

		foreach (static::getCustomColumnsByHook(EntityHook::AFTER_TITLE->value) as $customField) {
			if (!empty(static::getFilamentColumn($customField))) {
				$columns[] = static::getFilamentColumn($customField);
			}
		}

		foreach (static::getCustomColumnsByHook(EntityHook::AFTER_SLUG->value) as $customField) {
			if (!empty(static::getFilamentColumn($customField))) {
				$columns[] = static::getFilamentColumn($customField);
			}
		}

		foreach (static::getCustomColumnsByHook(EntityHook::AFTER_LAST->value) as $customField) {
			if (!empty(static::getFilamentColumn($customField))) {
				$columns[] = static::getFilamentColumn($customField);
			}
		}

		if (static::resourceHasMedia()) {
			$columns[] = IconColumn::make('has_images')
				->label('img')
				->width('5%')
				->toggleable()
				->boolean()
				->trueIcon('bi-file-image')
				->trueColor('secondary')
				->size('md')
				->state(fn($record) => ($record->hasImageCount()) ? true : null)
				->visibleFrom('2xl');
		}

		if (static::resourceHasFiles()) {
			$columns[] = IconColumn::make('has_documents')
				->label('doc')
				->width('5%')
				->toggleable()
				->boolean()
				->trueIcon('bi-file-earmark-text')
				->trueColor('secondary')
				->size('md')
				->state(fn($record) => ($record->hasFiles()) ? true : null)
				->visibleFrom('2xl');
		}

		if (static::resourceHasVideos() || static::resourceHasVideoFiles()) {
			$columns[] = IconColumn::make('has_videos')
				->label('vid')
				->width('5%')
				->toggleable()
				->boolean()
				->trueIcon('bi-file-play')
				->trueColor('secondary')
				->size('md')
				->state(fn($record) => ($record->hasVideos() || $record->hasVideoFiles()) ? true : null)
				->visibleFrom('2xl');
		}

		if (static::resourceHasGroups()) {
			$columns[] = TextColumn::make('cgroup')
				->label(_q('lara-admin::default.column.cgroup'))
				->width('10%')
				->toggleable()
				->visibleFrom('2xl');
		} elseif (static::resourceHasTerms()) {
			$columns[] = TextColumn::make('terms')
				->label(_q('lara-admin::default.column.terms'))
				->width('10%')
				->toggleable()
				->getStateUsing(function ($record) {
					$terms = $record->terms->pluck('title')->toArray();

					return implode(', ', $terms);
				})
				->visibleFrom('2xl');
		} else {
			$columns[] = TextColumn::make('user.name')
				->label(_q('lara-admin::default.column.user_id'))
				->width('10%')
				->toggleable()
				->visibleFrom('2xl');
		}

		// dd($columns);

		return $columns;
	}

	private static function getBaseTableFilters(): array
	{

		$filters = array();

		// filter by group
		if (static::getEntity()->objrel_has_groups && static::getEntity()->filter_by_group) {
			$filters[] = SelectFilter::make('cgroup')
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.cgroup'))
				->options(function () {
					$modelClass = static::getEntity()->model_class;

					return $modelClass::select('cgroup')->distinct()->langIs(static::$clanguage)->pluck('cgroup', 'cgroup')->toArray();
				})
				->default(fn() => (static::getSlug() == 'pages') ? 'page' : null);
		}

		// filter by relation
		foreach (static::getEntityRelationFilters() as $filter) {
			$filters[] = SelectFilter::make($filter->foreign_key)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.' . $filter->foreign_key))
				->options(function () use ($filter) {
					$relatedModelClass = $filter->relatedEntity->model_class;

					return $relatedModelClass::langIs(static::$clanguage)->pluck('title', 'id')->toArray();
				});
		}

		// filter by status
		if (static::getEntity()->show_status && static::getEntity()->filter_by_status) {
			$filters[] = SelectFilter::make('publish')
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.publish'))
				->options(function () {
					return [
						1 => 'published',
						0 => 'draft',
					];
				});
		}

		// filter by category
		if (static::getEntity()->objrel_has_terms) {

			if (static::getEntity()->filter_by_category) {
				$filters[] = SelectFilter::make('categories')
					->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.categories'))
					->relationship(
						name: 'categories',
						titleAttribute: 'title',
						modifyQueryUsing: function ($query) {
							return $query->where('language', 'nl')->where('resource_slug', static::getSlug());
						}
					);

			}

			if (static::getEntity()->filter_by_tag) {
				$filters[] = SelectFilter::make('tags')
					->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.tags'))
					->relationship(
						name: 'tags',
						titleAttribute: 'title',
						modifyQueryUsing: function ($query) {
							return $query->where('language', 'nl')->where('resource_slug', static::getSlug());
						}
					);
			}

		}

		// filter by author
		if (static::getEntity()->show_author && static::getEntity()->filter_by_author) {
			$filters[] = SelectFilter::make('user_id')
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.author'))
				->options(function () {
					$modelClass = static::getEntity()->model_class;

					return User::whereIn('id', $modelClass::select('user_id')->distinct()->langIs(static::$clanguage)->pluck('user_id')->toArray())->pluck('name', 'id')->toArray();
				});
		}

		// filter by custom field
		foreach (static::getEntity()->customfields()->isFilter()->get() as $filter) {
			$filters[] = SelectFilter::make($filter->field_name)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.' . $filter->field_name))
				->options(function () use ($filter) {
					$modelClass = static::getEntity()->model_class;
					$fname = $filter->field_name;

					return $modelClass::select($fname)->distinct()->whereNotNull($fname)->whereNot($fname, '')->langIs(static::$clanguage)->pluck($fname, $fname)->toArray();
				});
		}

		if (static::getEntity()->filter_by_trashed) {
			$filters[] = TrashedFilter::make();
		}

		return $filters;
	}

	private static function getBaseTableActions(): array
	{

		$actions = array();

		if (static::showViewAction()) {
			$actions[] = ViewAction::make()
				->label('');
		}
		if (static::showEditAction()) {
			$actions[] = EditAction::make()
				->label('');
		}
		if (static::showDeleteAction()) {
			$actions[] = DeleteAction::make()
				->label('');
		}
		if (static::showRestoreAction()) {
			$actions[] = RestoreAction::make()
				->label('');
		}

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

		static::setContentLanguage();

		$query->langIs(static::$clanguage)
			->withCount('images')
			->withCount('files')
			->withCount('videos')
			->withCount('videofiles');

		return $query;

	}

	private static function getSortOrder($query)
	{
		if(static::getSecondarySortField() && static::getSecondarySortOrder()) {
			return $query
				->orderBy(static::getPrimarySortField(), static::getPrimarySortOrder())
				->orderBy(static::getSecondarySortField(), static::getSecondarySortOrder());
		} else {
			return $query
				->orderBy(static::getPrimarySortField(), static::getPrimarySortOrder());
		}
	}

	private static function getCustomColumnsByHook($hook)
	{
		$cacheKey = 'lara_entity_table_custom_fields_' . static::getSlug() . '_' . $hook;

		return Cache::rememberForever($cacheKey, function () use ($hook) {
			return static::getEntity()->customfields()->where('field_hook', $hook)->where('show_in_list', 1)->get();
		});
	}

	private static function getCustomDateColumn()
	{
		$cacheKey = 'lara_entity_custom_date_field_' . static::getSlug();

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

	private static function getEntityRelationFilters()
	{
		$cacheKey = 'lara_entity_relation_filters_' . static::getSlug();

		return Cache::rememberForever($cacheKey, function () {
			return static::getEntity()->relations()->isFilter()->get();
		});

	}
}
