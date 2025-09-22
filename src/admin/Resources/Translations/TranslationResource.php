<?php

namespace Lara\Admin\Resources\Translations;

use BackedEnum;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\Lara\LaraResource;
use Lara\Admin\Resources\Translations\Schemas\TranslationForm;
use Lara\Admin\Resources\Translations\Tables\TranslationsTable;
use Lara\Admin\Traits\HasNavGroup;
use Lara\Common\Models\Translation;
use UnitEnum;

class TranslationResource extends LaraResource
{

	use HasNavGroup;

	protected static ?string $model = Translation::class;

	protected static ?string $module = 'lara-admin';

	protected static bool $shouldRegisterNavigation = true;

	protected static ?int $navigationSort = 900;

	protected static string|BackedEnum|null $navigationIcon = null;

	protected static ?string $clanguage = null;

	public static function getModule(): string
	{
		return static::$module;
	}

	public static function getSlug(?Panel $panel = null): string
	{
		return 'translations';
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
		return TranslationForm::configure($schema);
	}

	public static function table(Table $table): Table
	{
		return TranslationsTable::configure($table);
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListTranslations::route('/'),
			// 'create' => Pages\CreateTranslation::route('/create'),
			// 'edit'   => Pages\EditTranslation::route('/{record}/edit'),
		];
	}

}
