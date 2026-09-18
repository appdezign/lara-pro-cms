<?php

namespace Lara\Common\Entities\Config;

use Lara\Common\Models\Entity;

/**
 * Object relation options for an entity (the `objrel_*` columns).
 */
final readonly class RelationOptions
{

	/**
	 * @param list<string> $groupValues
	 */
	public function __construct(
		public bool $hasTerms,
		public bool $hasGroups,
		public array $groupValues,
		public bool $hasRelated,
		public bool $isRelatable,
	) {}

	public static function fromEntity(Entity $entity): self
	{
		$groupValues = $entity->objrel_group_values;

		return new self(
			hasTerms: (bool) $entity->objrel_has_terms,
			hasGroups: (bool) $entity->objrel_has_groups,
			groupValues: is_array($groupValues) ? array_values($groupValues) : [],
			hasRelated: (bool) $entity->objrel_has_related,
			isRelatable: (bool) $entity->objrel_is_relatable,
		);
	}

}
