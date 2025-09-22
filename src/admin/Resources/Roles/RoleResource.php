<?php

namespace Lara\Admin\Resources\Roles;

use BackedEnum;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\Roles\Schemas\RoleForm;
use Lara\Admin\Resources\Roles\Tables\RolesTable;
use Lara\Admin\Traits\HasNavGroup;
use Spatie\Permission\Models\Role;
use UnitEnum;

class RoleResource extends Resource
{

	use HasNavGroup;

	protected static ?string $model = Role::class;

	protected static ?string $module = 'lara-admin';

	protected static bool $shouldRegisterNavigation = true;

	protected static ?int $navigationSort = 900;

	protected static string|BackedEnum|null $navigationIcon = null;

	public static function getModule(): string
	{
		return static::$module;
	}

	public static function getSlug(?Panel $panel = null): string
	{
		return 'roles';
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
		return RoleForm::configure($schema);
	}

	public static function table(Table $table): Table
	{
		return RolesTable::configure($table);
	}

	public static function getPages(): array
	{
		return [
			'index'  => Pages\ListRoles::route('/'),
			'create' => Pages\CreateRole::route('/create'),
			'edit'   => Pages\EditRole::route('/{record}/edit'),
		];
	}

}
