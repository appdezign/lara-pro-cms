<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Http\Request;
use Lara\Front\Services\FrontMenuRepository;

/**
 * Menu lookups for a front controller.
 *
 * The logic lives in FrontMenuRepository, which takes FrontRouteResolver and
 * FrontTermRepository as constructor dependencies. This trait is the
 * compatibility shim that keeps the existing controller and widget call sites
 * working; new code should inject FrontMenuRepository instead.
 */
trait HasFrontMenu
{
	private function frontMenuRepository(): FrontMenuRepository
	{
		return app(FrontMenuRepository::class);
	}

	private function getHomePage(string $language)
	{
		return $this->frontMenuRepository()->getHomePage($language);
	}

	private function getMainMenuId()
	{
		return $this->frontMenuRepository()->getMainMenuId();
	}

	private function getActiveMenuArray($getIdOnly = false)
	{
		return $this->frontMenuRepository()->getActiveMenuArray($getIdOnly);
	}

	private function getMenuTag(string $language, object $entity, Request $request)
	{
		return $this->frontMenuRepository()->getMenuTag($language, $entity, $request);
	}

	private function getSingleMenuTag(string $language, object $entity, Request $request)
	{
		return $this->frontMenuRepository()->getSingleMenuTag($language, $entity, $request);
	}

	private function getMenuEntityRoutes(string $language): mixed
	{
		return $this->frontMenuRepository()->getMenuEntityRoutes($language);
	}

	private function getPageChildren($language)
	{
		return $this->frontMenuRepository()->getPageChildren($language);
	}
}
