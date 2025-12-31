<?php

namespace Lara\Admin\Resources\Entities\RelationManagers\Concerns;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Schema;
use Lara\Common\Models\EntityRelation;

trait HasRelations
{

	private static function checkRelations($entity): void
	{

		// hasOne, hasMany relations
		$relations = $entity->relations()->whereIn('type', ['hasOne', 'hasMany'])->get();
		foreach ($relations as $relation) {
			// find opposite relation
			$check = EntityRelation::where('type', 'belongsTo')
				->where('entity_id', $relation->related_entity_id)
				->where('related_entity_id', $relation->entity_id)
				->first();
			if (empty($check)) {
				$belongsToRelation = EntityRelation::create([
					'type'              => 'belongsTo',
					'entity_id'         => $relation->related_entity_id,
					'related_entity_id' => $relation->entity_id,
					'foreign_key'       => $relation->foreign_key,
				]);
				static::checkForeignKeyColumn($belongsToRelation);
			}

		}

		// belongsTo relations
		$relations = $entity->relations()->where('type', 'belongsTo')->get();
		foreach ($relations as $relation) {
			// find opposite relation
			$check = EntityRelation::whereIn('type', ['hasOne', 'hasMany'])
				->where('entity_id', $relation->related_entity_id)
				->where('related_entity_id', $relation->entity_id)
				->first();
			if (empty($check)) {
				// delete orphan
				$relation->delete();
			} else {
				// check table
				static::checkForeignKeyColumn($relation);
			}
		}

		// check models
		foreach ($entity->relations as $relation) {

			$modelClass = $relation->entity->model_class;
			if ($relation->type == 'hasMany') {
				// plural
				$method = $relation->relatedEntity->resource_slug;
			} else {
				// singular
				$method = $relation->relatedEntity->label_single;
			}

			if (!method_exists($modelClass, $method)) {
				Notification::make()
					->title('Relation not found in model !')
					->body('Method: (' . $relation->type . ') \'' . $method . '\'  not found in model: ' . $modelClass . '<br><br>Make sure you add the appropriate method to your model.')
					->seconds(30)
					->danger()
					->send();
			}
		}
	}

	private static function checkForeignKeyColumn($relation): void
	{
		if ($relation->type == 'belongsTo') {
			$modelClass = $relation->entity->model_class;
			$relatedModelClass = $relation->relatedEntity->model_class;
			$tablename = $modelClass::getTableName();
			$reltablename = $relatedModelClass::getTableName();
			$colname = $relation->foreign_key;

			if (!Schema::hasColumn($tablename, $colname)) {
				Schema::table($tablename, function ($table) use ($reltablename, $colname) {
					$table->bigInteger($colname)->unsigned()->after('id');
					$table->foreign($colname)
						->references('id')
						->on($reltablename)
						->onDelete('cascade');
				});
			}
		}
	}
}
