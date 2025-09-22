<?php

namespace Lara\Admin\Resources\Users;

use BackedEnum;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\Users\Schemas\UserForm;
use Lara\Admin\Resources\Users\Tables\UsersTable;
use Lara\Admin\Traits\HasBasicLaraEntity;
use Lara\Admin\Traits\HasNavGroup;
use Lara\Common\Models\User;
use UnitEnum;

class UserResource extends Resource
{

	use HasBasicLaraEntity;
	use HasNavGroup;

	protected static ?string $model = User::class;

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
		return 'users';
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
		return UserForm::configure($schema);
	}

	public static function table(Table $table): Table
	{
		return UsersTable::configure($table);
	}

	public static function getPages(): array
	{
		return [
			'index'  => Pages\ListUsers::route('/'),
			'create' => Pages\CreateUser::route('/create'),
			'edit'   => Pages\EditUser::route('/{record}/edit'),
		];
	}

}
