<?php

namespace Lara\Front\Http\Concerns;

use Lara\Front\Services\FrontPageContext;

/**
 * Shared page context for a front request.
 *
 * The logic lives in FrontPageContext, a stateless service. This trait is the
 * compatibility shim that keeps the existing call sites working - it is mixed
 * into the front controllers, every front widget and the service provider, so
 * new code should inject FrontPageContext instead.
 */
trait HasFrontend
{
	private function frontPageContext(): FrontPageContext
	{
		return app(FrontPageContext::class);
	}

	private function getSettingsByGroup(string $group)
	{
		return $this->frontPageContext()->getSettingsByGroup($group);
	}

	private function getFrontLanguageVersions(string $curlang, ?object $entity = null, ?object $object = null)
	{
		return $this->frontPageContext()->getFrontLanguageVersions($curlang, $entity, $object);
	}

	private function getGlobalWidgets($language)
	{
		return $this->frontPageContext()->getGlobalWidgets($language);
	}

	private function getFrontLaraVersion()
	{
		return $this->frontPageContext()->getFrontLaraVersion();
	}

	private function getFirstPageLoad()
	{
		return $this->frontPageContext()->getFirstPageLoad();
	}
}
