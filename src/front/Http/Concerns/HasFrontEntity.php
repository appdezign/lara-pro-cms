<?php

namespace Lara\Front\Http\Concerns;

use Lara\Front\Http\Lara\FrontActiveRoute;
use Lara\Front\Services\FrontEntityResolver;

/**
 * Entity and active-route resolution for a front controller.
 *
 * The logic lives in FrontEntityResolver, a stateless service. This trait is
 * the compatibility shim that keeps the existing controller call sites
 * working; new code should inject FrontEntityResolver instead.
 */
trait HasFrontEntity
{
    private function frontEntityResolver(): FrontEntityResolver
    {
        return app(FrontEntityResolver::class);
    }

    /**
     * Get the Lara Entity class for a route name.
     *
     * Deliberately untyped: this returns a LaraEntity subclass for a content
     * entity, but a LaraTool subclass for the non-database resources (search,
     * users), and those two hierarchies are unrelated.
     */
    private function getFrontEntity(string $routename): ?object
    {
        return $this->frontEntityResolver()->getFrontEntity($routename);
    }

    private function getLaraActiveRoute(string $routename): FrontActiveRoute
    {
        return $this->frontEntityResolver()->getLaraActiveRoute($routename);
    }

    /**
     * Get the Lara Entity class by resource slug.
     */
    private function getResourceBySlug(string $resourceSlug)
    {
        return $this->frontEntityResolver()->getResourceBySlug($resourceSlug);
    }
}
