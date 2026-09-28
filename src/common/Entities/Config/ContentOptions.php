<?php

namespace Lara\Common\Entities\Config;

use Lara\Common\Models\Entity;

/**
 * Content column options for an entity (the `col_*` and `show_rich_*` columns).
 */
final readonly class ContentOptions
{
    public function __construct(
        public bool $hasLead,
        public bool $hasBody,
        public int $extraBodyFields,
        public bool $hasStatus,
        public bool $hasExpiration,
        public bool $hasHideInList,
        public bool $richLead,
        public bool $richBody,
    ) {}

    public static function fromEntity(Entity $entity): self
    {
        return new self(
            hasLead: (bool) $entity->col_has_lead,
            hasBody: (bool) $entity->col_has_body,
            extraBodyFields: (int) $entity->col_extra_body_fields,
            hasStatus: (bool) $entity->col_has_status,
            hasExpiration: (bool) $entity->col_has_expiration,
            hasHideInList: (bool) $entity->col_has_hideinlist,
            richLead: (bool) $entity->show_rich_lead,
            richBody: (bool) $entity->show_rich_body,
        );
    }
}
