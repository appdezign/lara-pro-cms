<?php

namespace Lara\Admin\Resources\Tags;

use BackedEnum;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\Base\Schemas\LaraBaseForm;
// use Lara\Admin\Resources\Tags\Schemas\TagForm;
use Lara\Admin\Resources\Tags\Schemas\TagForm;
use Lara\Admin\Resources\Tags\Tables\TagsTable;
use Lara\Admin\Traits\HasFilters;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasLaraEntity;
use Lara\Admin\Traits\HasMedia;
use Lara\Admin\Traits\HasNavGroup;
use Lara\Admin\Traits\HasParams;
use Lara\Admin\Traits\HasReorder;
use Lara\Common\Models\Tag;
use UnitEnum;

class TagResource extends Resource
{

	use HasNavGroup;
	use LaraBaseForm;
	use TagForm;
	use HasLanguage;
	use HasMedia;
	use HasParams;
	use HasReorder;
	use HasFilters;
	use HasLaraEntity;

	protected static ?string $model = Tag::class;

	protected static ?string $module = 'lara-admin';

	protected static bool $shouldRegisterNavigation = false;

	public static ?string $clanguage = null;

	protected static string|BackedEnum|null $navigationIcon = null;

	protected static ?string $resourceSlug = null;

	protected static ?int $taxonomyId = null;

	public static function getModule(): string
	{
		return static::$module;
	}

	public static function getSlug(?Panel $panel = null): string
	{
		return 'tags';
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
		return static::getNavGroup('modules');
	}

	public static function form(Schema $schema): Schema
	{
		return $schema
			->components([
				Tabs::make('Tabs')
					->tabs(static::getTagFormTabs())
					->columnSpanFull()
					->persistTab()
					->id(static::getSlug() . '-tab'),
			]);
	}

	public static function table(Table $table): Table
	{
		return TagsTable::configure($table);
	}

	public static function getPages(): array
	{
		return [
			'index'   => Pages\ListTags::route('/'),
			'create'  => Pages\CreateTag::route('/create'),
			'edit'    => Pages\EditTag::route('/{record}/edit'),
			'reorder' => Pages\ReorderTags::route('/reorder'),
		];
	}

}
