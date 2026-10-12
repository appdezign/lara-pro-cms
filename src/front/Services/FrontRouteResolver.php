<?php

namespace Lara\Front\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Lara\Common\Models\MenuItem;
use Lara\Front\Http\Lara\FrontActiveRoute;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Resolves SEO route names for entities and handles front redirect decisions.
 *
 * Extracted from the HasFrontRoutes trait, which is now a delegating shim.
 */
final class FrontRouteResolver
{
    public function __construct(
        private readonly FrontEntityResolver $entityResolver,
    ) {}

    /**
     * Get the Laravel route name from the given url
     *
     * @return mixed
     */
    public function getRouteFromUrl(string $url)
    {
        // NOTE: v10

        return app('router')->getRoutes()->match(app('request')->create($url))->getName();
    }

    /**
     * Get a complete Frontent SEO Route for a specific entity list or object
     *
     * @return string
     */
    public function getFrontSeoRoute(string $resourceSlug, string $method, bool $single = false)
    {

        if ($resourceSlug == 'pages') {
            $method = 'show';
        }

        $entity = $this->entityResolver->getResourceBySlug($resourceSlug);

        $entityView = $entity->getViews()->where('method', $method)->first();

        if ($entityView) {
            // menu routes are registered per locale, so only a menu item in the current locale has one
            $menuItem = MenuItem::langIs(LaravelLocalization::getCurrentLocale())
                ->where('entity_id', $entity->getEntityId())
                ->where('entity_view_id', $entityView->id)
                ->whereNull('tag_id')
                ->first();

            if ($menuItem) {
                if ($menuItem->is_home == 1) {
                    return 'special.home.show';
                } else {
                    return $this->buildRouteName($menuItem->routename, $single);
                }
            }
        }

        if (Route::has('contenttag.'.$resourceSlug.'.'.$method)) {
            return $this->buildRouteName('contenttag.'.$resourceSlug.'.'.$method, $single);
        } else {
            return $this->buildRouteName('content.'.$resourceSlug.'.'.$method, $single);
        }

    }

    private function buildRouteName(string $routename, bool $single = false)
    {
        if ($single) {
            return $routename.'.show';
        } else {
            return $routename;
        }
    }

    public function checkFrontRedirect($language, $entity, $activeroute, $object)
    {

        if (empty($object)) {

            // object not found, redirect to list
            return $this->redirectToEntityList($entity, $activeroute);

        } else {

            // redirect entity objects to their menu url, if possible
            $isPreview = $this->checkEntityRoute($language, $entity, $activeroute, $object);
            if ($isPreview instanceof RedirectResponse) {
                return $isPreview;
            }

            // if the page is not a preview, make sure it is visible
            if (! $isPreview && $this->isHiddenObject($entity, $object)) {
                return $this->redirectToEntityList($entity, $activeroute);
            }

        }
    }

    /**
     * Whether an object is hidden from visitors, by the same rules as the lists: not published
     * (entities with a status) or expired (entities with an expiration).
     */
    public function isHiddenObject(object $entity, object $object): bool
    {
        return ($entity->hasStatus() && ! $object->isPublishedNow())
            || ($entity->hasExpiration() && $object->hasExpired());
    }

    /**
     * The list route of an entity for the current request: the list route of the menu item the
     * request came through (from the route context), otherwise the entity's own list route.
     */
    public function getEntityListRoute(object $entity, FrontActiveRoute $activeroute): ?string
    {
        $listRoute = $activeroute->getMenuRoute() ?? $this->getFrontSeoRoute($entity->getResourceSlug(), 'index');

        return Route::has($listRoute) ? $listRoute : null;
    }

    private function redirectToEntityList(object $entity, FrontActiveRoute $activeroute): RedirectResponse
    {
        $listRoute = $this->getEntityListRoute($entity, $activeroute);

        return $listRoute ? redirect()->route($listRoute) : redirect(route('error.show.404', '404'));
    }

    /**
     * Check if a page with a preview route can be redirected to a menu route
     *
     * @return false|RedirectResponse false to show the page, or a redirect
     */
    public function checkPageRoute(object $entity, FrontActiveRoute $activeroute, object $page): false|RedirectResponse
    {

        if ($entity->getResourceSlug() == 'pages' && $activeroute->getPrefix() == 'content') {

            // a page with a menu route is always shown there, so a preview moves to its menu url,
            // in the language of the page
            // a page in several menus: the first menu, then the first position in its tree
            $menuitem = MenuItem::langIs($page->language)
                ->where('type', 'page')
                ->where('object_id', $page->id)
                // only items that get a route ($laraMenuItemIsRoutable in laracms/app/Routes/web.php)
                ->whereNotNull('route')
                ->where('route', '!=', '')
                ->has('entity')
                ->has('entityview')
                ->orderBy('menu_id')
                ->orderBy('lft')
                ->first();

            if ($menuitem) {
                return redirect($page->language.'/'.$menuitem->route);
            } else {
                // this is a preview page, check if user is logged in
                if (Auth::check()) {
                    return false;
                } else {
                    return redirect(route('error.show.404', '404'));
                }
            }

        } else {
            return false;
        }

    }

    /**
     * Check if a page with a preview route can be redirected to a menu route
     *
     * @return bool|RedirectResponse true for a preview, false for a public route, or a redirect
     */
    public function checkEntityRoute(string $language, object $entity, FrontActiveRoute $activeroute, object $object): bool|RedirectResponse
    {

        if ($activeroute->getPrefix() != 'content' && $activeroute->getPrefix() != 'contenttag') {
            return false;
        }

        // only a visible object moves to its public url; a hidden one stays a preview
        if (! $this->isHiddenObject($entity, $object)) {

            $menuitem = MenuItem::langIs($language)->where('type', 'entity')
                ->where('entity_id', $entity->getEntityId())
                ->whereNull('tag_id')
                ->first();

            if ($menuitem) {

                $redirectUrl = $language.'/'.$menuitem->route.'/'.$object->slug;

                if ($entity->hasTags()) {
                    $redirectUrl = $redirectUrl.'.html';
                }

                return redirect($redirectUrl);

            }

        }

        // this is a preview page, check if user is logged in
        return Auth::check() ? true : redirect(route('error.show.404', '404'));

    }
}
