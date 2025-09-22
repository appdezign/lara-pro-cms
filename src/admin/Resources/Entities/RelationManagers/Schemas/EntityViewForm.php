<?php

namespace Lara\Admin\Resources\Entities\RelationManagers\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

use Lara\Admin\Enums\EntityViewListTypes;
use Lara\Admin\Enums\EntityViewTags;

class EntityViewForm
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
						TextInput::make('title')
							->label(_q(static::module() . '::' . static::slug() . '.column.title')),
						TextInput::make('method')
							->label(_q(static::module() . '::' . static::slug() . '.column.method')),
						TextInput::make('filename')
							->label(_q(static::module() . '::' . static::slug() . '.column.filename')),
						TextInput::make('template')
							->label(_q(static::module() . '::' . static::slug() . '.column.template'))
							->visible(fn(Get $get, $record, $operation): bool => $operation == 'edit' && $record->entity->resource_slug == 'pages' && $get('is_single')),
						TextInput::make('template_extra_fields')
							->label(_q(static::module() . '::' . static::slug() . '.column.template_extra_fields'))
							->numeric()
							->default(0)
							->visible(fn(Get $get, $record, $operation): bool => $operation == 'edit' && $record->entity->resource_slug == 'pages' && $get('is_single')),
						Toggle::make('is_single')
							->label(_q(static::module() . '::' . static::slug() . '.column.is_single'))
							->live()
							->afterStateUpdated(function (callable $set) {
								$set('list_type', null);
								$set('image_required', false);
								$set('showtags', null);
								$set('paginate', null);
								$set('infinite', false);
								$set('prevnext', false);
							}),

						Hidden::make('list_type'),
						Hidden::make('image_required'),
						Hidden::make('showtags'),
						Hidden::make('paginate'),
						Hidden::make('infinite'),
						Hidden::make('prevnext'),

						Select::make('list_type')
							->label(_q(static::module() . '::' . static::slug() . '.column.list_type'))
							->live()
							->options(EntityViewListTypes::class)
							->required()
							->visible(fn(Get $get, $operation): bool => $operation == 'edit' && !$get('is_single')),
						Toggle::make('image_required')
							->label(_q(static::module() . '::' . static::slug() . '.column.image_required'))
							->visible(fn(Get $get, $operation): bool => $operation == 'edit' && Str::startsWith($get('list_type'), 'grid')),
						Select::make('showtags')
							->label(_q(static::module() . '::' . static::slug() . '.column.showtags'))
							->options(EntityViewTags::class)
							->placeholder('none')
							->visible(fn(Get $get, $operation): bool => $operation == 'edit' && !$get('is_single')),
						Select::make('paginate')
							->label(_q(static::module() . '::' . static::slug() . '.column.paginate'))
							->options(static::getPagination())
							->placeholder('None')
							->visible(fn(Get $get, $operation): bool => $operation == 'edit' && !$get('is_single')),
						Toggle::make('infinite')
							->label(_q(static::module() . '::' . static::slug() . '.column.infinite'))
							->visible(fn(Get $get, $operation): bool => $operation == 'edit' && !$get('is_single')),
						Toggle::make('prevnext')
							->label(_q(static::module() . '::' . static::slug() . '.column.prevnext'))
							->visible(fn(Get $get, $operation): bool => $operation == 'edit' && $get('is_single')),
						Toggle::make('publish')
							->label(_q(static::module() . '::' . static::slug() . '.column.publish')),

					]),

			]);
	}

	private static function getPagination(): array
	{
		$array = [];
		for ($i = 1; $i <= 100; $i++) {
			$array[$i] = $i;
		}

		return $array;
	}

	private static function slug(): string {
		return static::$slug;
	}

	private static function module(): string {
		return static::$module;
	}

}
