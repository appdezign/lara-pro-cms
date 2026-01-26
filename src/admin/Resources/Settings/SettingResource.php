<?php

namespace Lara\Admin\Resources\Settings;

use BackedEnum;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\Settings\Schemas\SettingForm;
use Lara\Admin\Resources\Settings\Tables\SettingsTable;
use Lara\Admin\Traits\HasNavGroup;
use Lara\Common\Models\Setting;
use UnitEnum;

class SettingResource extends Resource
{

	use HasNavGroup;

	protected static ?string $model = Setting::class;

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
		return 'settings';
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
		return static::getNavGroup('tools');
	}

	public static function form(Schema $schema): Schema
	{
		return SettingForm::configure($schema);
	}

	public static function table(Table $table): Table
	{
		return SettingsTable::configure($table);
	}

	public static function getPages(): array
	{
		return [
			'index'  => Pages\ListSettings::route('/'),
			'create' => Pages\CreateSetting::route('/create'),
			'edit'   => Pages\EditSetting::route('/{record}/edit'),
			'view'   => Pages\ViewSetting::route('/{record}'),
		];
	}

}
