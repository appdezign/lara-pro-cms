<?php

namespace Lara\Admin\Resources\Entities\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Lara\Admin\Enums\EntityGroup;
use Lara\Admin\Resources\Entities\EntityResource;

class EntitiesTable
{
	private static function rs(): EntityResource
	{
		$class = EntityResource::class;

		return new $class;
	}

	public static function configure(Table $table): Table
	{

		return $table
			->columns([
				TextColumn::make('title')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title')),
				TextColumn::make('resource_slug')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.resource_slug')),
				TextColumn::make('nav_group')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.nav_group')),
				TextColumn::make('position')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.nav_group')),
				TextColumn::make('cgroup')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.cgroup')),
			])
			->filters([
				SelectFilter::make('cgroup')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.cgroup'))
					->options(EntityGroup::class)
					->default('entity'),
			], layout: FiltersLayout::AboveContent)
			->persistFiltersInSession()
			->deferFilters(false)
			->actions([
				EditAction::make()->label(''),
				DeleteAction::make()
					->label('')
					->disabled(function ($record) {
						$entityModelClass = $record->model_class;
						return $entityModelClass::count() > 0;
					}),
			])
			->bulkActions([])
			->modifyQueryUsing(function ($query) {
				$query->orderBy('position');

				return $query;
			});
	}
}
