<?php

namespace Lara\Admin\Resources\MenuItems;

use BackedEnum;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\MenuItems\Schemas\MenuItemForm;
use Lara\Admin\Resources\MenuItems\Tables\MenuItemsTable;
use Lara\Admin\Traits\HasNavGroup;
use Lara\Common\Models\MenuItem;
use UnitEnum;

class MenuItemResource extends Resource
{

	use HasNavGroup;

	protected static ?string $model = MenuItem::class;

	protected static ?string $module = 'lara-admin';

	protected static bool $shouldRegisterNavigation = true;

	protected static ?int $navigationSort = 900;

	protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bars-3';

	protected static ?string $clanguage = null;

	public static function getModule(): string
	{
		return static::$module;
	}

	public static function getSlug(?Panel $panel = null): string
	{
		return 'menu-items';
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
		return null;
	}

	public static function form(Schema $schema): Schema
	{
		return MenuItemForm::configure($schema);
	}

	public static function table(Table $table): Table
	{
		return MenuItemsTable::configure($table);
	}

	public static function getPages(): array
	{
		return [
			'index'  => Pages\ListMenuItems::route('/'),
			'create' => Pages\CreateMenuItem::route('/create'),
			'edit'   => Pages\EditMenuItem::route('/{record}/edit'),
		];
	}

}
