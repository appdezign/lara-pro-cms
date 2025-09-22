<?php

namespace Lara\Admin\Resources\Forms\RelationManagers\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FormViewForm
{
	protected static ?string $slug = 'entityviews';
	protected static ?string $module = 'lara-admin';

	public static function configure(Schema $schema): Schema
	{
		return $schema
			->components([
				Section::make('Content')
					->columnSpanFull()
					->collapsible()
					->schema([
						Hidden::make('is_single')->default(1),
						TextInput::make('title')
							->label(_q(static::module() . '::' . static::slug() . '.column.title')),
						TextInput::make('method')
							->label(_q(static::module() . '::' . static::slug() . '.column.method')),
						TextInput::make('filename')
							->label(_q(static::module() . '::' . static::slug() . '.column.filename')),
						Toggle::make('publish')
							->label(_q(static::module() . '::' . static::slug() . '.column.publish')),
					]),
			]);
	}

	private static function slug(): string
	{
		return static::$slug;
	}

	private static function module(): string
	{
		return static::$module;
	}

}
