<?php

namespace Lara\Admin\Resources\Menus;

use BackedEnum;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\Menus\Schemas\MenuForm;
use Lara\Admin\Resources\Menus\Tables\MenusTable;
use Lara\Admin\Traits\HasNavGroup;
use Lara\Common\Models\Menu;
use UnitEnum;

class MenuResource extends Resource
{

	use HasNavGroup;
	use MenusTable;

	protected static ?string $model = Menu::class;

	protected static ?string $module = 'lara-admin';

	protected static bool $shouldRegisterNavigation = false;

	protected static ?int $navigationSort = 900;

	protected static string|BackedEnum|null $navigationIcon = null;

	public static function getModule(): string
	{
		return static::$module;
	}

	public static function getSlug(?Panel $panel = null): string
	{
		return 'menus';
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

	public static function getNavigationGroup(): string|UnitEnum|null
	{
		return static::getNavGroup('users');
	}

	public static function form(Schema $schema): Schema
	{
		return MenuForm::configure($schema);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns(static::getMenuTableColumns())
			->filters([])
			->actions(static::getMenuTableActions())
			->bulkActions([]);
	}

	public static function getPages(): array
	{
		return [
			'index'  => Pages\ListMenus::route('/'),
			'create' => Pages\CreateMenu::route('/create'),
			'edit'   => Pages\EditMenu::route('/{record}/edit'),
			'reorder'  => Pages\MenuReorder::route('/{record}/reorder'),
		];
	}

}
