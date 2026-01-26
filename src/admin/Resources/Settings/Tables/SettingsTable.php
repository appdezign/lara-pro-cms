<?php

namespace Lara\Admin\Resources\Settings\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Lara\Admin\Resources\Settings\SettingResource;
use Lara\Common\Models\Setting;

class SettingsTable
{
	private static function rs(): SettingResource
	{
		$class = SettingResource::class;
		return new $class;
	}

	public static function configure(Table $table): Table
	{
		return $table
			->columns([
				TextColumn::make('title')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title')),
				TextColumn::make('cgroup')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.cgroup')),
				TextColumn::make('value')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.value')),
				IconColumn::make('locked_by_admin')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.locked_by_admin'))
					->boolean()
					->trueIcon('bi-lock')
					->trueColor('danger')
					->state(fn($record) => ($record->locked_by_admin) ? true : null)
					->size('sm'),
			])
			->filters([
				SelectFilter::make('cgroup')
					->options(Setting::select('cgroup')->distinct()->pluck('cgroup', 'cgroup')->toArray())
			], layout: FiltersLayout::AboveContent)->persistFiltersInSession()
			->deferFilters(false)
			->actions([
				ViewAction::make()
					->label(''),
				EditAction::make()
					->label('')
					->tableIcon(fn($record) => $record->isLocked() ? 'bi-lock' : 'bi-pencil-square')
					->disabled(fn($record) => $record->isLocked()),
				DeleteAction::make()
					->label('')
					->tableIcon(fn($record) => $record->isLocked() ? 'bi-lock' : 'bi-trash3')
					->disabled(fn($record) => $record->isLocked()),
			]);
	}
}
