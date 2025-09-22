<?php

namespace Lara\Admin\Resources\Settings\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Lara\Admin\Resources\Settings\SettingResource;

class SettingForm
{
	private static function rs(): SettingResource
	{
		$class = SettingResource::class;
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
						TextInput::make('title')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title'))
							->disabled(fn(string $operation): bool => $operation == 'edit'),
						TextInput::make('cgroup')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.cgroup'))
							->disabled(fn(string $operation): bool => $operation == 'edit'),
						TextInput::make('key')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.key'))
							->disabled(fn(string $operation): bool => $operation == 'edit'),
						TextInput::make('value')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.value')),
						Checkbox::make('locked_by_admin')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.locked_by_admin'))
							->inline(false),

					]),
			]);
	}

}
