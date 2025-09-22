<?php

namespace Lara\Admin\Resources\Entities;

use BackedEnum;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\Entities\Schemas\EntityForm;
use Lara\Admin\Resources\Entities\Tables\EntitiesTable;
use Lara\Admin\Traits\HasNavGroup;
use Lara\Common\Models\Entity;
use UnitEnum;

class EntityResource extends Resource
{

	use HasNavGroup;

	protected static ?string $model = Entity::class;

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
		return 'entities';
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
		return static::getNavGroup('builder');
	}

	public static function form(Schema $schema): Schema
	{
		return EntityForm::configure($schema);
	}

	public static function table(Table $table): Table
	{
		return EntitiesTable::configure($table);
	}

	public static function getRelations(): array
	{
		return [
			RelationManagers\CustomFieldsRelationManager::class,
			RelationManagers\EntityViewsRelationManager::class,
			RelationManagers\EntRelRelationManager::class,
		];;
	}

	public static function getPages(): array
	{
		return [
			'index'  => Pages\ListEntities::route('/'),
			'create' => Pages\CreateEntity::route('/create'),
			'edit'   => Pages\EditEntity::route('/{record}/edit'),
		];
	}

}
