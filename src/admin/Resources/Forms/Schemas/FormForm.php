<?php

namespace Lara\Admin\Resources\Forms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Lara\Admin\Enums\FormGroup;
use Lara\Admin\Enums\NavGroup;

use Lara\Admin\Resources\Forms\FormResource;

class FormForm
{

	private static function rs(): FormResource
	{
		$class = FormResource::class;
		return new $class;
	}

	public static function configure(Schema $schema): Schema
	{

		return $schema
			->components([
				Tabs::make('Tabs')
					->columnSpanFull()
					->tabs([
						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.info', true))
							->schema([
								Section::make('info')
									->collapsible()
									->schema(static::getInfoSection())
									->extraAttributes(['class' => 'first-entity-section']),
							]),
						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.manager', true))
							->schema([])
							->visible(fn(string $operation): bool => $operation === 'edit'),

					])
					->persistTab()
					->id('entity-form-tab'),
			]);
	}

	public static function getInfoSection(): array
	{

		$rows = array();

		$rows[] = TextInput::make('title')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title'))
			->visible(fn(string $operation): bool => $operation === 'edit');
		$rows[] = TextInput::make('resource_slug')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.resource_slug'))
			->unique()
			->visible(fn(string $operation): bool => $operation === 'edit')
			->disabled();
		$rows[] = TextInput::make('label_single')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.label_single'))
			->required()
			->disabled(fn(string $operation): bool => $operation === 'edit');
		$rows[] = TextInput::make('resource')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.resource'))
			->visible(fn(string $operation): bool => $operation === 'edit')
			->disabled();
		$rows[] = TextInput::make('model_class')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.model_class'))
			->visible(fn(string $operation): bool => $operation === 'edit')
			->disabled();
		$rows[] = TextInput::make('controller')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.controller'))
			->visible(fn(string $operation): bool => $operation === 'edit')
			->disabled();
		$rows[] = Select::make('nav_group')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.nav_group'))
			->options(NavGroup::toArray())
			->default('forms');
		$rows[] = TextInput::make('position')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.position'))
			->numeric();
		$rows[] = Select::make('cgroup')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.cgroup'))
			->options( FormGroup::toArray())
			->native(false)
			->required()
			->disabled(fn(string $operation): bool => $operation === 'edit');

		return $rows;

	}


}
