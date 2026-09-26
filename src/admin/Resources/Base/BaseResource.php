<?php

namespace Lara\Admin\Resources\Base;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Lara\Admin\Concerns\HasLanguage;
use Lara\Admin\Concerns\HasLaraEntity;
use Lara\Admin\Concerns\HasLayout;
use Lara\Admin\Concerns\HasMedia;
use Lara\Admin\Concerns\HasNestedSet;
use Lara\Admin\Concerns\HasParams;
use Lara\Admin\Resources\Base\Concerns\HasBaseForm;
use Lara\Admin\Resources\Base\Concerns\HasBasePolicy;
use Lara\Admin\Resources\Base\Concerns\HasBaseTable;

class BaseResource extends Resource
{
	use HasBaseForm;
	use HasBasePolicy;
	use HasBaseTable;
	use HasLanguage;
	use HasLaraEntity;
	use HasLayout;
	use HasMedia;
	use HasNestedSet;
	use HasParams;

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
		return _q(static::getModule().'::'.static::getSlug().'.model.label_single');
	}

	public static function getPluralModelLabel(): string
	{
		return _q(static::getModule().'::'.static::getSlug().'.model.label_plural');
	}

	public static function getNavigationLabel(): string
	{
		return _q(static::getModule().'::'.static::getSlug().'.navigation.label', true);
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
					->key('lara-tabs')
					->tabs(static::getLaraFormTabs())
					->columnSpanFull()
					->persistTab()
					->id(function (string $operation, $record): string {
						if ($operation === 'edit') {
							return static::getSlug().'-'.$record->id.'-tab';
						}

						return static::getSlug().'-tab';
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
			->deferLoading()
			->columns(static::getBaseTableColumns())
			->filters(static::getBaseTableFilters(), layout: $filterLayout)
			->deferFilters(false)
			->persistFiltersInSession()
			->deferColumnManager(false)
			->actions(static::getBaseTableActions())
			->bulkActions(static::getBaseTableBulkActions())
			->modifyQueryUsing(fn (Builder $query) => static::getBaseQuery($query))
			->defaultSort(fn (Builder $query) => static::getSortOrder($query));
	}

	public static function getEloquentQuery(): Builder
	{
		$query = parent::getEloquentQuery();
		if (static::getEntity()->filter_by_trashed) {
			$query->withoutGlobalScopes([SoftDeletingScope::class]);
		}

		return $query;
	}
}
