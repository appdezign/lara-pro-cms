<?php

namespace Lara\Front\Http\Concerns;

use Lara\Front\Http\Lara\FrontActiveRoute;
use Lara\Front\Services\FrontViewResolver;

/**
 * Theme view, layout and grid resolution for a front controller.
 *
 * The logic lives in FrontViewResolver, a stateless service. This trait is the
 * compatibility shim that keeps the existing controller call sites working; new
 * code should inject FrontViewResolver instead of mixing this in.
 */
trait HasFrontView
{
    private function frontViewResolver(): FrontViewResolver
    {
        return app(FrontViewResolver::class);
    }

    private function getEntityView(object $entity, FrontActiveRoute $activeroute)
    {
        return $this->frontViewResolver()->getEntityView($entity, $activeroute);
    }

    private function getFrontViewFile(object $entity, FrontActiveRoute $activeroute)
    {
        return $this->frontViewResolver()->getFrontViewFile($entity, $activeroute);
    }

    private function checkThemeViewFile(object $entity, string $viewpath): bool
    {
        return $this->frontViewResolver()->checkThemeViewFile($entity, $viewpath);
    }

    private function getDefaultThemeLayout()
    {
        return $this->frontViewResolver()->getDefaultThemeLayout();
    }

    private function getGrid(object $layout)
    {
        return $this->frontViewResolver()->getGrid($layout);
    }

    private function getGridVars($entity)
    {
        return $this->frontViewResolver()->getGridVars($entity);
    }

    private function getGridOverride($entity, FrontActiveRoute $activeroute)
    {
        return $this->frontViewResolver()->getGridOverride($entity, $activeroute);
    }

    private function getObjectThemeLayout(object $object, ?object $params = null)
    {
        return $this->frontViewResolver()->getObjectThemeLayout($object, $params);
    }
}
