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

	use HasLaraEntity;
	use LaraBaseForm;
	use LaraBaseTable;
	use HasLanguage;
	use HasLayout;
	use HasMedia;
	use HasNestedSet;
	use HasParams;


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
					->id(function ($operation, $record): string {
						if($operation == 'edit') {
							return static::getSlug() . '-' . $record->id . '-tab';
						} else {
							return static::getSlug() . '-tab';
						}
					}),
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
			->modifyQueryUsing(fn(Builder $query) => static::getBaseQuery($query))
			->defaultSort(fn (Builder $query) => static::getSortOrder($query));
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

	// Use Spatie Roles and Permissions for access
	public static function canViewAny(): bool
	{
		return auth()->check() && auth()->user()->can('view_any_' . static::getSingleSlug());
	}

	public static function canView(Model $record): bool
	{
		return auth()->check() && auth()->user()->can('view_' . static::getSingleSlug());
	}

	public static function canCreate(): bool
	{
		return auth()->check() && auth()->user()->can('create_' . static::getSingleSlug());
	}

	public static function canEdit(Model $record): bool
	{
		return auth()->check() && auth()->user()->can('update_' . static::getSingleSlug());
	}

	public static function canDelete(Model $record): bool
	{
		return auth()->check() && auth()->user()->can('delete_' . static::getSingleSlug());
	}

	public static function canReorder(): bool
	{
		return auth()->check() && auth()->user()->can('update_' . static::getSingleSlug());
	}

	public static function canReplicate(Model $record): bool
	{
		return auth()->check() && auth()->user()->can('update_' . static::getSingleSlug());
	}

	public static function canForceDelete(Model $record): bool
	{
		return auth()->check() && auth()->user()->can('delete_' . static::getSingleSlug());
	}

	public static function canForceDeleteAny(): bool
	{
		return auth()->check() && auth()->user()->can('delete_' . static::getSingleSlug());
	}

	public static function canRestore(Model $record): bool
	{
		return auth()->check() && auth()->user()->can('delete_' . static::getSingleSlug());
	}

	public static function canRestoreAny(): bool
	{
		return auth()->check() && auth()->user()->can('delete_' . static::getSingleSlug());
	}

}
