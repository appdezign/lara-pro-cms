<?php

namespace Lara\Admin\Resources\Roles\Concerns;

use Illuminate\Support\Facades\Gate;

use Lara\Common\Models\Entity;

trait HasPermissions
{

	private static function getPoliciesFromGate(bool $group = false): array
	{

		$policies = array_keys(Gate::policies());

		if($group) {
			$cgroups = array();
			foreach ($policies as $model) {
				$labelSingle = strtolower(class_basename($model));
				$entity = Entity::where('label_single', $labelSingle)->first();
				if($entity) {
					$cgroups[$entity->cgroup][] = $labelSingle;
				} else {
					if(in_array($labelSingle, ['user', 'role'])) {
						$cgroups['auth'][] = $labelSingle;
					} else {
						$cgroups['system'][] = $labelSingle;
					}
				}
			}
			return $cgroups;
		} else {
			$modelNames = array();
			foreach ($policies as $model) {
				$labelSingle = strtolower(class_basename($model));
				$modelNames[] = $labelSingle;
			}
			return $modelNames;
		}
	}

}
