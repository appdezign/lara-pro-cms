<?php

namespace Lara\Front\Http\Concerns;

use Lara\Front\Http\Lara\FrontActiveRoute;
use Lara\Front\Services\FrontRouteResolver;

/**
 * SEO route resolution and redirect decisions for a front controller.
 *
 * The logic lives in FrontRouteResolver, which takes FrontEntityResolver as a
 * constructor dependency. This trait is the compatibility shim that keeps the
 * existing controller call sites working; new code should inject
 * FrontRouteResolver instead.
 */
trait HasFrontRoutes
{
	private function frontRouteResolver(): FrontRouteResolver
	{
		return app(FrontRouteResolver::class);
	}

	private function getRouteFromUrl(string $url)
	{
		return $this->frontRouteResolver()->getRouteFromUrl($url);
	}

	private function getFrontSeoRoute(string $resourceSlug, string $method, bool $single = false)
	{
		return $this->frontRouteResolver()->getFrontSeoRoute($resourceSlug, $method, $single);
	}

	private function checkFrontRedirect($language, $entity, $activeroute, $object)
	{
		return $this->frontRouteResolver()->checkFrontRedirect($language, $entity, $activeroute, $object);
	}

	private function checkPageRoute(string $language, object $entity, FrontActiveRoute $activeroute, int $id)
	{
		return $this->frontRouteResolver()->checkPageRoute($language, $entity, $activeroute, $id);
	}

	private function checkEntityRoute(string $language, object $entity, FrontActiveRoute $activeroute, object $object)
	{
		return $this->frontRouteResolver()->checkEntityRoute($language, $entity, $activeroute, $object);
	}
}
