<?php

namespace Lara\Front\Http\Concerns;

use Lara\Front\Http\Lara\FrontActiveRoute;
use Lara\Front\Services\FrontObjectRepository;

/**
 * Single content objects, SEO data and page metadata for a front controller.
 *
 * The logic lives in FrontObjectRepository, which takes FrontRouteResolver as
 * a constructor dependency. This trait is the compatibility shim that keeps
 * the existing controller call sites working; new code should inject
 * FrontObjectRepository instead.
 */
trait HasFrontObject
{
	private function frontObjectRepository(): FrontObjectRepository
	{
		return app(FrontObjectRepository::class);
	}

	private function getSingleFrontObject(string $language, object $entity, string $slug)
	{
		return $this->frontObjectRepository()->getSingleFrontObject($language, $entity, $slug);
	}

	private function getPageObjectId(?int $id, FrontActiveRoute $activeroute)
	{
		return $this->frontObjectRepository()->getPageObjectId($id, $activeroute);
	}

	private function getHeroPage(object $object, ?object $menuTag, object $modulePage)
	{
		return $this->frontObjectRepository()->getHeroPage($object, $menuTag, $modulePage);
	}

	private function getFrontRelated($entity, int $id)
	{
		return $this->frontObjectRepository()->getFrontRelated($entity, $id);
	}

	private function getEmailPageContent(string $language, string $resourceSlug)
	{
		return $this->frontObjectRepository()->getEmailPageContent($language, $resourceSlug);
	}

	private function getModulePageBySlug(string $language, object $entity, string $method)
	{
		return $this->frontObjectRepository()->getModulePageBySlug($language, $entity, $method);
	}

	private function getSeo(object $object, ?object $fallback = null)
	{
		return $this->frontObjectRepository()->getSeo($object, $fallback);
	}

	private function getDefaultSeo(string $language)
	{
		return $this->frontObjectRepository()->getDefaultSeo($language);
	}

	private function getEntityListUrl($language, $entity, FrontActiveRoute $activeroute, $object, $menuTag, $ispreview): ?string
	{
		return $this->frontObjectRepository()->getEntityListUrl($language, $entity, $activeroute, $object, $menuTag, $ispreview);
	}

	private function isPreview($routename)
	{
		return $this->frontObjectRepository()->isPreview($routename);
	}
}
