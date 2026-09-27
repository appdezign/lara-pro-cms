<?php

namespace Lara\Common\Entities;

/**
 * Base for the non-database "tool" resources (search, users).
 *
 * Unlike LaraEntity these have no row in lara_resource_entities; they only carry
 * a resource slug and module so the frontend can treat them like an entity.
 *
 * Routing state lives in Lara\Front\Http\Lara\FrontActiveRoute, not here.
 */
class LaraTool
{
    public ?string $resource_slug = null;

    protected ?string $module = null;

    protected ?string $prefix = null;

    protected ?string $method = null;

    protected ?string $cgroup = null;

    public function getModule(): ?string
    {
        return $this->module;
    }

    public function getResourceSlug(): ?string
    {
        return $this->resource_slug;
    }

    public function getCgroup(): ?string
    {
        return $this->cgroup;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method = null): void
    {
        $this->method = $method;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(?string $prefix = null): void
    {
        $this->prefix = $prefix;
    }
}
