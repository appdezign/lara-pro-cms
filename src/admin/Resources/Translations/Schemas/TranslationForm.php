<?php

namespace Lara\Admin\Resources\Translations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Lara\Admin\Resources\Translations\TranslationResource;

class TranslationForm
{
	private static function rs(): TranslationResource
	{
		$class = TranslationResource::class;
		return new $class;
	}

	public static function configure(Schema $schema): Schema
	{
		return $schema
			->components([
				Section::make('Content')
					->columnSpanFull()
					->collapsible()
					->schema([
							TextInput::make('language')
								->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.language'))
								->disabled()
								->maxLength(255),
							TextInput::make('module')
								->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.module'))
								->disabled()
								->maxLength(255),
							TextInput::make('resource')
								->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.resource'))
								->disabled()
								->maxLength(255),
							TextInput::make('tag')
								->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.tag'))
								->disabled()
								->maxLength(255),
							TextInput::make('key')
								->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.key'))
								->disabled()
								->maxLength(255),
							TextInput::make('value')
								->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.value'))
								->maxLength(255),

						]
					),
			]);
	}

}
