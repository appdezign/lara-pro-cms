<?php

namespace Lara\Admin\Traits;

use Lara\Common\Models\Entity;

trait HasLaraResource
{

	private static function getResourceByModel($modelClass) {
		$entity = Entity::where('model_class', $modelClass)->first();
		if($entity) {
			$resourceClass = $entity->resource;
			return new $resourceClass;
		} else {
			return null;
		}
	}
}
