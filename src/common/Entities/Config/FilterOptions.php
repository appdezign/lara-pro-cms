<?php

namespace Lara\Common\Entities\Config;

use Lara\Common\Models\Entity;

/**
 * Table filter options for an entity (the `filter_*` columns).
 */
final readonly class FilterOptions
{
    public function __construct(
        public bool $byTrashed,
        public bool $byGroup,
        public bool $byStatus,
        public bool $byCategory,
        public bool $byTag,
        public bool $byAuthor,
        public bool $isOpen,
    ) {}

    public static function fromEntity(Entity $entity): self
    {
        return new self(
            byTrashed: (bool) $entity->filter_by_trashed,
            byGroup: (bool) $entity->filter_by_group,
            byStatus: (bool) $entity->filter_by_status,
            byCategory: (bool) $entity->filter_by_category,
            byTag: (bool) $entity->filter_by_tag,
            byAuthor: (bool) $entity->filter_by_author,
            isOpen: (bool) $entity->filter_is_open,
        );
    }
}
