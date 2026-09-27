<?php

namespace Lara\Front\Http\Concerns;

use Lara\Common\Models\Tag;
use Lara\Front\Services\FrontTermRepository;

/**
 * Tags, taxonomies and term trees for a front controller.
 *
 * The logic lives in FrontTermRepository, a stateless service. This trait is
 * the compatibility shim that keeps the existing controller and widget call
 * sites working; new code should inject FrontTermRepository instead.
 */
trait HasFrontTerms
{
    private function frontTermRepository(): FrontTermRepository
    {
        return app(FrontTermRepository::class);
    }

    private function getTagTreeWithCount($language, $entity)
    {
        return $this->frontTermRepository()->getTagTreeWithCount($language, $entity);
    }

    private function getFrontDefaultTaxonomy()
    {
        return $this->frontTermRepository()->getFrontDefaultTaxonomy();
    }

    private function getTagsFromCollection(string $language, object $entity, object $objects)
    {
        return $this->frontTermRepository()->getTagsFromCollection($language, $entity, $objects);
    }

    private function getTagChildren(string $language, object $entity, ?string $term)
    {
        return $this->frontTermRepository()->getTagChildren($language, $entity, $term);
    }

    private function getTagBySlug(string $language, object $entity, ?string $slug): ?Tag
    {
        return $this->frontTermRepository()->getTagBySlug($language, $entity, $slug);
    }
}
