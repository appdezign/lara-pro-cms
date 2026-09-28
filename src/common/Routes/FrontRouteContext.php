<?php

namespace Lara\Common\Routes;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;

/**
 * What a menu route is about: its menu item, entity, method, tags and object.
 *
 * Stored in the route's action array under the "lara" key when the route is registered, and
 * read back by the front controllers and the active-menu lookup. The action array is part of
 * the route cache, and unlike route defaults it is never passed to controller methods.
 *
 * Before this, the same information was encoded in the route name and read back by position
 * (`entitytag.docs.26.index`), which forced the menu item ID into every name.
 */
final readonly class FrontRouteContext
{
    public const ACTION_KEY = 'lara';

    /**
     * @param  list<string>  $tags  the active tag path, e.g. ['laravel'] or ['parent', 'child']
     * @param  string|null  $singleRoute  the route that shows one object of this list
     * @param  string|null  $menuRoute  the list route of the menu item itself
     * @param  string|null  $tagRoutePattern  the list route of one tag, with a {tag} placeholder
     */
    public function __construct(
        public ?int $menuItemId,
        public string $prefix,
        public string $resourceSlug,
        public string $method,
        public array $tags = [],
        public ?int $objectId = null,
        public ?string $singleRoute = null,
        public ?string $menuRoute = null,
        public ?string $tagRoutePattern = null,
    ) {}

    /**
     * The context of the route that shows one object of this list.
     */
    public function forShow(): self
    {
        return new self($this->menuItemId, $this->prefix, $this->resourceSlug, 'show', $this->tags, $this->objectId, $this->singleRoute, $this->menuRoute, $this->tagRoutePattern);
    }

    public function attachTo(Route $route): Route
    {
        return $route->setAction([...$route->getAction(), self::ACTION_KEY => $this->toArray()]);
    }

    public static function forRoute(?Route $route): ?self
    {
        $context = $route?->getAction(self::ACTION_KEY);

        return is_array($context) ? self::fromArray($context) : null;
    }

    public static function forRouteName(?string $routeName): ?self
    {
        if (empty($routeName)) {
            return null;
        }

        return self::forRoute(RouteFacade::getRoutes()->getByName($routeName));
    }

    /**
     * @return array{menu_item_id: int|null, prefix: string, resource_slug: string, method: string, tags: list<string>, object_id: int|null, single_route: string|null, menu_route: string|null, tag_route_pattern: string|null}
     */
    public function toArray(): array
    {
        return [
            'menu_item_id' => $this->menuItemId,
            'prefix' => $this->prefix,
            'resource_slug' => $this->resourceSlug,
            'method' => $this->method,
            'tags' => $this->tags,
            'object_id' => $this->objectId,
            'single_route' => $this->singleRoute,
            'menu_route' => $this->menuRoute,
            'tag_route_pattern' => $this->tagRoutePattern,
        ];
    }

    /**
     * @param  array<string, mixed>  $context
     */
    public static function fromArray(array $context): self
    {
        return new self(
            menuItemId: $context['menu_item_id'] ?? null,
            prefix: $context['prefix'],
            resourceSlug: $context['resource_slug'],
            method: $context['method'],
            tags: $context['tags'] ?? [],
            objectId: $context['object_id'] ?? null,
            singleRoute: $context['single_route'] ?? null,
            menuRoute: $context['menu_route'] ?? null,
            tagRoutePattern: $context['tag_route_pattern'] ?? null,
        );
    }
}
