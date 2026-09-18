<?php

namespace Lara\Admin\Resources\BaseForm;

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
use Lara\Admin\Resources\BaseForm\Concerns\HasBaseForm;
use Lara\Admin\Resources\BaseForm\Concerns\HasBaseTable;
use Lara\Admin\Concerns\HasLanguage;
use Lara\Admin\Concerns\HasLaraEntity;
use Lara\Admin\Concerns\HasLayout;
use Lara\Admin\Concerns\HasNestedSet;
use Lara\Admin\Concerns\HasParams;

class BaseFormResource extends Resource
{

	use HasLaraEntity;
	use HasBaseForm;
	use HasBaseTable;
	use HasLanguage;
	use HasLayout;
	use HasNestedSet;
	use HasParams;
	use HasBasePolicy;

	protected static ?string $model = null;

	protected static ?string $module = 'lara-app';

	protected static bool $shouldRegisterNavigation = false;

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

	protected static string|BackedEnum|null $navigationIcon = null;

	protected static ?string $clanguage = null;

	public static function form(Schema $schema): Schema
	{
		return $schema
			->components([
				Tabs::make('Tabs')
					->tabs(static::getLaraFormTabs())
					->columnSpanFull()
					->persistTab()
					->id(static::getSlug() . '-tab'),
			]);
	}

	public static function table(Table $table): Table
	{
		static::setContentLanguage();

		$filterLayout = (static::getEntity()->filter_is_open) ? FiltersLayout::AboveContent : FiltersLayout::AboveContentCollapsible;

		return $table
			->columns(static::getBaseTableColumns())
			->filters(static::getBaseTableFilters(), layout: $filterLayout)
			->deferFilters(false)
			->persistFiltersInSession()
			->deferColumnManager(false)
			->actions(static::getBaseTableActions())
			->bulkActions(static::getBaseTableBulkActions())
			->modifyQueryUsing(fn(Builder $query) => static::getBaseQuery($query));
	}

	public static function getEloquentQuery(): Builder
	{
		if (static::getEntity()->filter_by_trashed) {
			return parent::getEloquentQuery()
				->withoutGlobalScopes([
					SoftDeletingScope::class,
				]);

		} else {
			return parent::getEloquentQuery();
		}
	}

	private static function getSingleSlug(): string
	{
		return Str::singular(static::getSlug());
	}

}
