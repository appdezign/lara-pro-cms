<?php

namespace Lara\Admin\Resources\Menus\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Lara\Admin\Resources\Menus\MenuResource;

class MenuForm
{
	private static function rs(): MenuResource
	{
		$class = MenuResource::class;
		return new $class;
	}

	public static function configure(Schema $schema): Schema
	{
		return $schema
			->components([
				Section::make('Content')
					->collapsible()
					->schema([
						TextInput::make('title')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title'))
							->required()
							->maxLength(255),
						TextInput::make('slug')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.slug'))
							->disabled(fn(string $operation) : bool => $operation === 'edit')
							->maxLength(255),
					]),
			]);
	}
}
