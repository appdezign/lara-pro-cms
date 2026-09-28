<?php

namespace Lara\Common\Routes;

use Lara\Common\Models\Entity;
use Lara\Common\Models\MenuItem;

/**
 * Middleware for a dynamically registered front route.
 *
 * Front routes are built at boot from the menu and the entity rows, in two
 * separate route files (the core front module and the app module). Both need
 * the same rule: require auth when the entity or the menu item asks for it, and
 * response-cache in production. That rule was copy-pasted seven times.
 */
final class FrontRouteMiddleware
{
    /**
     * @param  bool  $allowResponseCache  The /content/ fallback routes are
     *                                    deliberately not response-cached.
     * @return list<string>
     */
    public static function build(
        ?Entity $entity,
        ?MenuItem $menuItem = null,
        bool $allowResponseCache = true,
    ): array {

        $middleware = [];

        if (($entity && $entity->has_front_auth == 1) || ($menuItem && $menuItem->route_has_auth)) {
            $middleware[] = 'auth';
        }

        if ($allowResponseCache && config('app.env') === 'production' && config('responsecache.enabled')) {
            $middleware[] = 'cacheResponse';
        }

        return $middleware;

    }
}
