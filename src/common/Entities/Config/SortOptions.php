<?php

namespace Lara\Common\Entities\Config;

use Lara\Common\Models\Entity;

/**
 * Sort options for an entity (the `sort_*` columns).
 */
final readonly class SortOptions
{

	public function __construct(
		public bool $isSortable,
		public string $primaryField,
		public string $primaryOrder,
		public ?string $secondaryField,
		public ?string $secondaryOrder,
	) {}

	public static function fromEntity(Entity $entity): self
	{
		return new self(
			isSortable: (bool) $entity->sort_is_sortable,
			primaryField: $entity->sort_primary_field ?: 'id',
			primaryOrder: $entity->sort_primary_order ?: 'asc',
			secondaryField: $entity->sort_secondary_field ?: null,
			secondaryOrder: $entity->sort_secondary_order ?: null,
		);
	}

}
