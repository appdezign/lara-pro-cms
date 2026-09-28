<?php

namespace Lara\Front\Services;

use Lara\Common\Entities\LaraEntity;
use Lara\Common\Routes\FrontRouteContext;
use Lara\Front\Http\Lara\FrontActiveRoute;
use stdClass;

/**
 * Resolves the Lara entity and active-route context for a front request.
 *
 * Extracted from the HasFrontEntity trait, which is now a delegating shim.
 */
final class FrontEntityResolver
{
    /**
     * Get the Lara Entity Class
     *
     * @return LaraEntity|null
     */
    public function getFrontEntity(string $routename)
    {

        $route = $this->prepareFrontRoute($routename);
        $lara = $this->getLaraClass($route->resource_slug);

        if (class_exists($lara)) {
            return new $lara;
        } else {
            return null;
        }

    }

    /**
     * @return FrontActiveRoute
     */
    public function getLaraActiveRoute(string $routename)
    {

        $route = $this->prepareFrontRoute($routename);

        $entityRoute = new FrontActiveRoute;

        $entityRoute->setPrefix($route->prefix);
        $entityRoute->setMethod($route->method);

        if (isset($route->menu_id)) {
            $entityRoute->setMenuId($route->menu_id);
        }

        if (isset($route->object_id)) {
            $entityRoute->setObjectId($route->object_id);
        }

        $entityRoute->setActiveRoute($routename);

        // menu routes know their single route; for the others it is the list route plus ".show"
        $entityRoute->setSingleRoute($route->single_route ?? $routename.'.show');

        $entityRoute->setMenuRoute($route->menu_route ?? null);
        $entityRoute->setTagRoutePattern($route->tag_route_pattern ?? null);

        if (isset($route->activetags)) {
            $entityRoute->setActiveTags($route->activetags);
        }

        return $entityRoute;

    }

    /**
     * Get the Lara Entity Class by key
     *
     * @return mixed|null
     */
    public function getResourceBySlug(string $resourceSlug)
    {

        $lara = $this->getLaraClass($resourceSlug);

        if ($lara) {
            $entity = new $lara;
        } else {
            $entity = null;
        }

        return $entity;

    }

    /**
     * Translate entity key to an FQN
     *
     * @return string
     */
    private function getLaraClass(string $resourceSlug)
    {

        $laraClass = '\Lara\Common\Entities\\'.ucfirst($resourceSlug).'Entity';

        if (! class_exists($laraClass)) {

            $laraClass = '\Lara\App\Entities\\'.ucfirst($resourceSlug).'Entity';

            if (! class_exists($laraClass)) {

                $laraClass = null;

            }

        }

        return $laraClass;

    }

    /**
     * @return stdClass
     */
    private function prepareFrontRoute(?string $routename = null)
    {

        $route = new stdClass;

        if (empty($routename)) {

            $route = $this->getDefaultRoute();

        } elseif ($context = FrontRouteContext::forRouteName($routename)) {

            // menu routes carry their context; see FrontRouteContext
            $route = $this->getMenuRoute($context);

        } else {

            $parts = explode('.', $routename);

            if ($parts[0] == 'special') {

                $route = $this->getSpecialRoute($parts);

            } elseif ($parts[0] == 'error') {

                $route = $this->getErrorRoute($parts);

            } else {

                if ($parts[0] == 'content') {
                    $route = $this->getContentRoute($routename, $parts);
                } elseif ($parts[0] == 'contenttag') {
                    $route = $this->getContentTagRoute($routename, $parts);
                } elseif ($parts[0] == 'ajax') {
                    $route = $this->getAjaxFormRoute($routename, $parts);
                }

            }

        }

        return $route;

    }

    private function getContentTagRoute($routename, $parts)
    {

        $route = new stdClass;

        $route->prefix = $parts[0];
        $route->resource_slug = $parts[1];
        $route->method = end($parts);
        $route->activetags = [];

        if (end($parts) == 'show') {
            for ($i = 2; $i < (count($parts) - 2); $i++) {
                $route->activetags[] = $parts[$i];
            }
            // $route->parent_route = substr($routename, 0, -5);
        } else {
            for ($i = 2; $i < (count($parts) - 1); $i++) {
                $route->activetags[] = $parts[$i];
            }
        }

        return $route;
    }

    /**
     * @return stdClass
     */
    private function getMenuRoute(FrontRouteContext $context)
    {

        $route = new stdClass;

        $route->prefix = $context->prefix;
        $route->resource_slug = $context->resourceSlug;
        $route->menu_id = $context->menuItemId;
        $route->method = $context->method;
        $route->activetags = $context->tags;
        $route->single_route = $context->singleRoute;
        $route->menu_route = $context->menuRoute;
        $route->tag_route_pattern = $context->tagRoutePattern;

        if ($context->objectId !== null) {
            $route->object_id = $context->objectId;
        }

        return $route;
    }

    private function getContentRoute($routename, $parts)
    {

        $route = new stdClass;

        if (count($parts) == 3) {

            // get prefix, model and method from route
            [$route->prefix, $route->resource_slug, $route->method] = explode('.', $routename);

        }

        if (count($parts) == 4) {

            if (end($parts) == 'show') {

                // get prefix, model, parent-method, and method from route
                [$route->prefix, $route->resource_slug, $route->parent_method, $route->method] = explode('.', $routename);
                // $route->parent_route = $route->prefix . '.' . $route->resource_slug . '.' . $route->parent_method;

            } else {

                // get prefix, model, method and id from route
                [$route->prefix, $route->resource_slug, $route->menu_id, $route->method, $route->object_id] = explode('.', $routename);

            }

        }

        return $route;
    }

    private function getAjaxFormRoute($routename, $parts)
    {

        $route = new stdClass;

        if (count($parts) == 3) {
            [$route->prefix, $route->resource_slug, $route->method] = explode('.', $routename);
        }

        return $route;
    }

    private function getErrorRoute($parts)
    {

        $route = new stdClass;

        $route->prefix = 'error';
        $route->resource_slug = '404';
        $route->method = 'show';

        return $route;
    }

    private function getSpecialRoute($parts)
    {

        $route = new stdClass;

        if ($parts[1] == 'home') {
            $route->prefix = 'entity';
            $route->resource_slug = 'pages';
            $route->method = 'show';
        }

        if ($parts[1] == 'search') {
            $route->prefix = 'special';
            $route->resource_slug = 'search';
            $route->method = end($parts);
        }

        if ($parts[1] == 'user') {
            $route->prefix = 'special';
            $route->resource_slug = 'users';
            $route->method = end($parts);
        }

        return $route;

    }

    private function getDefaultRoute()
    {

        $route = new stdClass;

        $route->prefix = 'entity';
        $route->resource_slug = 'pages';
        $route->method = 'show';

        return $route;
    }
}
