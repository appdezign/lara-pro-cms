<?php

namespace Lara\Admin\Resources\Base;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use Lara\Admin\Resources\Base\Concerns\HasBasePolicy;
use Lara\Admin\Resources\Base\Schemas\LaraBaseForm;
use Lara\Admin\Resources\Base\Tables\LaraBaseTable;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasLaraEntity;
use Lara\Admin\Traits\HasLayout;
use Lara\Admin\Traits\HasMedia;
use Lara\Admin\Traits\HasNestedSet;
use Lara\Admin\Traits\HasParams;

class BaseResource extends Resource
{

	use HasLanguage;
	use HasLaraEntity;
	use HasLayout;
	use HasMedia;
	use HasNestedSet;
	use HasParams;
	use HasBasePolicy;
	use LaraBaseTable;
	use LaraBaseForm;

	protected static ?string $model = null;

	protected static ?string $module = 'lara-app';

	protected static bool $shouldRegisterNavigation = false;

	protected static string|BackedEnum|null $navigationIcon = null;

	public static function getModule(): string
	{
		return static::$module;
	}

	public static function getModelLabel(): string
	{
		return _q(static::getModule() . '::' . static::getSlug() . '.model.label_single');
	}

	public static function getPluralModelLabel(): string
	{
		return _q(static::getModule() . '::' . static::getSlug() . '.model.label_plural');
	}

	public static function getNavigationLabel(): string
	{
		return _q(static::getModule() . '::' . static::getSlug() . '.navigation.label', true);
	}

	public static function getNavigationGroup(): ?string
	{
		return static::getEntityNavGroup();
	}

	public static function getNavigationSort(): ?int
	{
		return static::getEntity()->position;
	}

	public static function form(Schema $schema): Schema
	{
		return $schema
			->components([
				Tabs::make('Tabs')
					->tabs(static::getLaraFormTabs())
					->columnSpanFull()
					->persistTab()
					->id(function (string $operation, Model $record): string {
						if ($operation === 'edit') {
							return static::getSlug() . '-' . $record->id . '-tab';
						}
						return static::getSlug() . '-tab';
					}),
			]);
	}

	public static function table(Table $table): Table
	{
		static::setContentLanguage();

		$filterLayout = static::getEntity()->filter_is_open
			? FiltersLayout::AboveContent
			: FiltersLayout::AboveContentCollapsible;

		return $table
			->columns(static::getBaseTableColumns())
			->filters(static::getBaseTableFilters(), layout: $filterLayout)
			->deferFilters(false)
			->persistFiltersInSession()
			->deferColumnManager(false)
			->actions(static::getBaseTableActions())
			->bulkActions(static::getBaseTableBulkActions())
			->modifyQueryUsing(fn(Builder $query) => static::getBaseQuery($query))
			->defaultSort(fn(Builder $query) => static::getSortOrder($query));
	}

	public static function getEloquentQuery(): Builder
	{
		$query = parent::getEloquentQuery();
		if (static::getEntity()->filter_by_trashed) {
			$query->withoutGlobalScopes([SoftDeletingScope::class]);
		}

		return $query;
	}

	private static function getSingleSlug(): string
	{
		return Str::singular(static::getSlug());
	}

}
