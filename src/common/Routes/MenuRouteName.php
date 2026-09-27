<?php

namespace Lara\Common\Routes;

use BackedEnum;
use Lara\Common\Models\Entity;
use Lara\Common\Models\EntityView;
use Lara\Common\Models\MenuItem;

/**
 * Names for the routes the menu produces.
 *
 * A name follows the menu item's URL: `media/downloads` for the docs entity becomes
 * `entitytag.docs.media.downloads.index`. URLs are unique within a language, so the names
 * are too - also when the same entity is in the menu twice. They used to contain the menu
 * item ID instead, which differs per database and was needed only because the controllers
 * read the menu item from the name. That now travels with the route (FrontRouteContext).
 *
 * The admin menu builder, the route file and `lara:menu:refresh-routenames` all name routes
 * here, so the recorded name of a menu item always matches the route it produces.
 */
final class MenuRouteName
{
    /**
     * The home page is always served by this route.
     */
    public const HOME = 'special.home.show';

    public static function make(string $prefix, string $resourceSlug, string $path, string $method): string
    {
        return implode('.', [$prefix, $resourceSlug, str_replace('/', '.', trim($path, '/')), $method]);
    }

    /**
     * The name a menu item records, or null when it produces no route of its own.
     */
    public static function forMenuItem(MenuItem $menuItem, ?Entity $entity, ?EntityView $entityView): ?string
    {
        $type = $menuItem->type instanceof BackedEnum ? $menuItem->type->value : $menuItem->type;

        if ($type == 'page' && $menuItem->is_home) {
            return self::HOME;
        }

        if (empty($menuItem->route) || ! $entity || ! $entityView || ! in_array($type, ['page', 'entity', 'form'], true)) {
            return null;
        }

        return self::make(self::prefixFor($type, $entity), $entity->resource_slug, $menuItem->route, $entityView->method);
    }

    public static function prefixFor(string $type, Entity $entity): string
    {
        return match (true) {
            $type == 'form' => 'form',
            $type == 'entity' && (bool) $entity->objrel_has_terms => 'entitytag',
            default => 'entity',
        };
    }
}
