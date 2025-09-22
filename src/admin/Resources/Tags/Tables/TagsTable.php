<?php

namespace Lara\Admin\Resources\Tags\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Lara\Admin\Resources\Tags\Pages\ListTags;
use Lara\Admin\Resources\Tags\TagResource;
use Lara\Admin\Traits\HasFilters;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasNestedSet;
use Lara\Admin\Traits\HasParams;
use Lara\Admin\Traits\HasReorder;
use Lara\Common\Models\Entity;

class TagsTable
{

	use HasFilters;
	use HasLanguage;
	use HasNestedSet;
	use HasParams;
	use HasReorder;

	protected static ?string $clanguage = null;
	protected static ?string $resourceSlug = null;
	protected static ?int $taxonomyId = null;

	private static function rs(): TagResource
	{
		$class = TagResource::class;
		return new $class;
	}

	public static function configure(Table $table): Table
	{

		static::setContentLanguage();

		static::$resourceSlug = static::getActiveFilterFromPage(ListTags::class, 'resource_slug', static::getDefaultResourceSlug());
		static::$taxonomyId = static::getActiveFilterFromPage(ListTags::class, 'taxonomy_id', static::getDefaultTxonomyId());

		return $table
			->columns([
				IconColumn::make('publish')
					->label(_q('lara-admin::default.column.publish'))
					->width('5%')
					->toggleable()
					->boolean()
					->size('md'),
				TextColumn::make('title')
					->label('')
					->width('40%')
					->html()
					->getStateUsing(function ($record) {
						return static::formatNestedTitle($record->title, $record->depth);
					}),
				TextColumn::make('taxonomy.title')
					->label('')
					->width('20%'),
				IconColumn::make('locked_by_admin')
					->label('')
					->width('10%')
					->boolean()
					->trueIcon('heroicon-o-lock-closed')
					->trueColor('gray')
					->state(fn($record) => ($record->locked_by_admin == 1) ? 1 : null)
					->size('md'),
			])
			->filters([
				SelectFilter::make('resource_slug')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.filter.resource_slug'))
					->options(Entity::where('objrel_has_terms', 1)->pluck('resource_slug', 'resource_slug')->toArray()),

				SelectFilter::make('taxonomy_id')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.filter.taxonomy_id'))
					->relationship('taxonomy', 'title'),
			], layout: FiltersLayout::AboveContent)
			->deferFilters(false)
			->persistFiltersInSession()
			->actions([
				EditAction::make()->label('')
			])
			->modifyQueryUsing(fn($query) => $query->langIs(static::$clanguage))
			->defaultSort('position')
			->paginated(false);

	}

}
