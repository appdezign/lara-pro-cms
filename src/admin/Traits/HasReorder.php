<?php

namespace Lara\Admin\Traits;

use Lara\Common\Models\Entity;
use Lara\Common\Models\Language;
use Lara\Common\Models\Taxonomy;

trait HasReorder
{


	private static function getDefaultTxonomyId() : ?int {
		$taxonomy = Taxonomy::where('is_default', 1)->first();
		if ($taxonomy) {
			return $taxonomy->id;
		} else {
			return null;
		}
	}

	private static function getDefaultResourceSlug() : ?string {
		$entity = Entity::where('cgroup', 'entity')->orderBy('position')->first();
		if($entity) {
			return $entity->resource_slug;
		} else {
			return null;
		}
	}

	private static function saveEntityOrder($language, $modelClass, $data): void
	{

		$languageId = Language::where('code', $language)->first()->value('id');

		$position = $languageId * 1000 + 1;
		foreach($data as $objectId) {

			$object = $modelClass::find($objectId);

			$object->position = $position;
			$object->save();

			$position++;

		}


	}
}
