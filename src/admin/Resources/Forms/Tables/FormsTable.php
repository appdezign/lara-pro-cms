<?php

namespace Lara\Admin\Resources\Forms\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Lara\Admin\Enums\FormGroup;
use Lara\Admin\Resources\Forms\FormResource;

class FormsTable
{
	private static function rs(): FormResource
	{
		$class = FormResource::class;
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
					->options(FormGroup::class)
					->default('form'),
			], layout: FiltersLayout::AboveContent)
			->persistFiltersInSession()
			->deferFilters(false)
			->actions([
				EditAction::make()->label(''),
			])
			->bulkActions([])
			->modifyQueryUsing(function ($query) {
				$query->where('cgroup', 'form')->orderBy('position');
				return $query;
			});
	}
}
