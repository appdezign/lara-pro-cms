<?php

namespace Lara\Admin\Resources\Base\Tables;

use Cache;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Lara\Admin\Enums\EntityHook;
use Lara\Admin\Resources\Base\Concerns\HasTableActions;
use Lara\Admin\Resources\Base\Concerns\HasTableCustomColumns;
use Lara\Admin\Resources\Base\Concerns\HasTableFilters;
use Lara\Admin\Resources\Base\Concerns\HasTableQuery;

use Usamamuneerchaudhary\FilaRank\Tables\SeoScoreColumn;

trait LaraBaseTable
{

	use HasTableActions;
	use HasTableCustomColumns;
	use HasTableFilters;
	use HasTableQuery;

	private static function getBaseTableColumns(): array
	{

		$columns = array();

		if (static::getEntity()->show_batch == 0) {
			$columns[] = TextColumn::make('id')
				->label(_q('lara-admin::default.tablecolumn.id'))
				->width('5%')
				->numeric()
				->toggleable()
				->sortable()
				->visibleFrom('xl');
		}

		$columns[] = IconColumn::make('publish')
			->label(_q('lara-admin::default.tablecolumn.publish'))
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
				->label(_q(static::getModule() . '::' . static::getSlug() . '.tablecolumn.' . $customDateColumn->field_name))
				->width('15%')
				->toggleable()
				->dateTime('j M Y')
				->sortable()
				->visibleFrom('2xl');
		} else {
			$columns[] = TextColumn::make('publish_from')
				->label(_q('lara-admin::default.tablecolumn.publish_from'))
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
			->label(_q(static::getModule() . '::' . static::getSlug() . '.tablecolumn.title'))
			->width('30%')
			->limit(40)
			->sortable()
			->searchable();

		if (static::resourceShowSeo()) {
			$columns[] = SeoScoreColumn::make()
				->label(_q('lara-admin::default.tablecolumn.seo'))
				->width('10%')
				->visibleFrom('2xl');
		}

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
				->state(fn($record) => ($record->hasImages()) ? true : null)
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
				->label(_q('lara-admin::default.tablecolumn.cgroup'))
				->width('10%')
				->toggleable()
				->visibleFrom('2xl');
		} elseif (static::resourceHasTerms()) {
			$columns[] = TextColumn::make('terms')
				->label(_q('lara-admin::default.tablecolumn.terms'))
				->width('10%')
				->toggleable()
				->getStateUsing(function ($record) {
					$terms = $record->terms->pluck('title')->toArray();

					return implode(', ', $terms);
				})
				->visibleFrom('2xl');
		} else {
			$columns[] = TextColumn::make('user.name')
				->label(_q('lara-admin::default.tablecolumn.user_id'))
				->width('10%')
				->toggleable()
				->visibleFrom('2xl');
		}

		return $columns;
	}

}
