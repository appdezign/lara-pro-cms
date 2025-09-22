<?php

namespace Lara\Common\Lara;

use Cache;

class LaraTool
{

	protected ?object $entity = null;
	public ?string $resource_slug = null;
	protected ?string $module; // eve, admin
	protected ?string $prefix = null;
	protected ?string $method = null;

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

	public function setMethod(string $method = null): void
	{
		$this->method = $method;
	}

	public function getPrefix(): ?string
	{
		return $this->prefix;
	}

	public function setPrefix(string $prefix = null): void
	{
		$this->prefix = $prefix;
	}

	public function getEntityRouteKey(): ?string
	{
		return $this->entity_route_key;
	}

	public function setEntityRouteKey(string $entity_route_key = null): void
	{
		$this->entity_route_key = $entity_route_key;
	}

	public function getActiveRoute(): ?string
	{
		return $this->active_route;
	}

	public function setActiveRoute(string $active_route = null): void
	{
		$this->active_route = $active_route;
	}

	public function getBaseEntityRoute(): ?string
	{
		return $this->base_entity_route;
	}

	public function setBaseEntityRoute(string $base_entity_route = null): void
	{
		$this->base_entity_route = $base_entity_route;
	}

	public function getParentRoute(): ?string
	{
		return $this->parent_route;
	}

	public function setParentRoute(string $parent_route = null): void
	{
		$this->parent_route = $parent_route;
	}

}
