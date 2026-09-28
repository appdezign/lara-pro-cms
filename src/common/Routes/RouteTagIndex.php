<?php

namespace Lara\Common\Routes;

use Illuminate\Support\Collection;
use Lara\Common\Models\Tag;

/**
 * Routable tags, grouped by resource slug.
 *
 * The front route files build one route per tag, for every term-enabled
 * entity. They used to run `Tag::resourceIs($slug)` inside those loops, which
 * is one query per entity - 16 round trips to fetch 60 rows on a typical
 * install. This reads them once and groups in memory.
 *
 * Registered as a container singleton, so the query happens at most once per
 * request. Route files are only evaluated when the route cache is cold, so in
 * production this runs once per `lara:route:cache` rather than per request.
 */
final class RouteTagIndex
{
    /**
     * @var Collection<string, Collection<int, Tag>>|null
     */
    private ?Collection $index = null;

    /**
     * Routable tags for one resource, in the same order as the per-slug query.
     *
     * @return Collection<int, Tag>
     */
    public function forResource(?string $resourceSlug): Collection
    {
        if ($resourceSlug === null || $resourceSlug === '') {
            return new Collection;
        }

        return $this->index()->get($resourceSlug, new Collection);
    }

    /**
     * Drop the cached index. Only needed when tags change within one process,
     * which in practice means tests.
     */
    public function flush(): void
    {
        $this->index = null;
    }

    /**
     * @return Collection<string, Collection<int, Tag>>
     */
    private function index(): Collection
    {
        return $this->index ??= Tag::whereNotNull('route')
            ->get()
            ->groupBy('resource_slug');
    }
}
