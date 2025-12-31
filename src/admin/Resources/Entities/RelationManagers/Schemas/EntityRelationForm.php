<?php

namespace Lara\Admin\Resources\Entities\RelationManagers\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Lara\Common\Models\Entity;
use function PHPUnit\Framework\isFalse;

class EntityRelationForm
{
	protected static ?string $slug = 'entityrelations';
	protected static ?string $module = 'lara-admin';

	public static function configure(Schema $schema): Schema
	{
		return $schema
			->components([
				Section::make('Content')
					->columnSpanFull()
					->schema([
						Placeholder::make('source')
							->label(_q(static::module() . '::' . static::slug() . '.column.source'))
							->content(fn ($record) => $record->entity->resource_slug)
							->visible(fn($operation) => $operation == 'edit'),
						Select::make('entity_id')
							->label(_q(static::module() . '::' . static::slug() . '.column.entity_id'))
							->options(function (RelationManager $livewire) {
								$entity = $livewire->getOwnerRecord();
								return [
									$entity->id => $entity->title,
								];
							})
							->default(function (RelationManager $livewire) {
								return $livewire->getOwnerRecord()->id;
							})
							->preload()
							->visible(fn($operation) => $operation == 'create'),
						Select::make('type')
							->label(_q(static::module() . '::' . static::slug() . '.column.type'))
							->options([
								'hasOne'  => 'hasOne',
								'hasMany' => 'hasMany',
							])
							->required()
							->visible(fn($operation) => $operation == 'create'),
						Select::make('type')
							->label(_q(static::module() . '::' . static::slug() . '.column.type'))
							->options([
								'hasOne'  => 'hasOne',
								'hasMany' => 'hasMany',
								'belongsTo' => 'belongsTo',
							])
							->required()
							->visible(fn($operation) => $operation == 'edit')
						->disabled(),
						Select::make('related_entity_id')
							->label(_q(static::module() . '::' . static::slug() . '.column.related_entity_id'))
							->live()
							->options(fn($state) => static::getRelatableEntities($state))
							->afterStateUpdated(function (callable $set, Get $get) {
								$entityId = $get('entity_id');
								if ($entityId) {
									$entity = Entity::find($entityId);
									if($entity) {
										$singularEntityLabel = Str::singular($entity->resource_slug);
										$foreignKey = $singularEntityLabel . '_id';
										$set('foreign_key', $foreignKey);
									}
								}
							})
							->disabled(fn(string $operation) => $operation == 'edit'),
						TextInput::make('foreign_key')
							->label(_q(static::module() . '::' . static::slug() . '.column.foreign_key'))
							->disabled(fn(string $operation) => $operation == 'edit'),

						Toggle::make('is_filter')
							->label(_q(static::module() . '::' . static::slug() . '.column.is_filter'))
							->visible(fn(Get $get) => $get('type') == 'belongsTo'),

					]),

			]);
	}

	private static function slug(): string {
		return static::$slug;
	}

	private static function module(): string {
		return static::$module;
	}

	private static function getRelatableEntities($state): array
	{
		$relatableEntities = array();

		if($state) {
			// get current entity
			$entity = Entity::find($state);
			if($entity) {
				$relatableEntities[$entity->id] = $entity->resource_slug;
			}
		} else {
			// get entities with no records
			$entities = Entity::where('cgroup', 'entity')->get();
			foreach ($entities as $entity) {
				$entityModelClass = $entity->model_class;
				$entcount = $entityModelClass::count();
				if ($entcount == 0) {
					$relatableEntities[$entity->id] = $entity->resource_slug;
				}
			}
		}


		return $relatableEntities;
	}

}
