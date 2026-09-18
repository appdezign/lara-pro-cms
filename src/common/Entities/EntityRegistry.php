<?php

namespace Lara\Common\Entities;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Lara\Common\Models\Entity;
use RuntimeException;

/**
 * Single source of truth for entity configuration.
 *
 * Every lara_resource_entities row lives behind one cache key, so one flush()
 * invalidates the lot on any cache driver. Before this existed, entity config
 * was cached under `entity_config_{slug}` (LaraEntity) and `lara_entity_{slug}`
 * (HasLaraEntity) with rememberForever and no Cache::forget anywhere, so the two
 * copies could disagree and neither could be invalidated except by wiping the
 * whole file cache.
 *
 * Values derived from entity config elsewhere (custom field schemas, table
 * columns, relation filters) append version() to their own cache key. Bumping
 * the version on flush() therefore invalidates that whole family at once,
 * without needing cache tags or a list of every derived key.
 */
class EntityRegistry
{

	private const CACHE_KEY = 'lara:entities:v1';

	private const VERSION_KEY = 'lara:entities:version';

	/**
	 * Eager loads for the relationships EntityConfig exposes.
	 *
	 * @var list<string>
	 */
	private const RELATIONS = ['customfields', 'views', 'relations'];

	/**
	 * In-process memo, so repeated lookups in one request do not re-hit the store.
	 *
	 * @var array<string, Entity>|null
	 */
	private ?array $entities = null;

	/**
	 * @var array<string, EntityConfig>
	 */
	private array $configs = [];

	private ?string $version = null;

	/**
	 * Config for a resource slug, or null when there is no such entity.
	 */
	public function find(string $resourceSlug): ?EntityConfig
	{
		if (array_key_exists($resourceSlug, $this->configs)) {
			return $this->configs[$resourceSlug];
		}

		$entity = $this->entities()[$resourceSlug] ?? null;

		if (!$entity) {
			return null;
		}

		return $this->configs[$resourceSlug] = EntityConfig::fromEntity($entity);
	}

	/**
	 * Config for a resource slug.
	 *
	 * @throws RuntimeException when the slug is not registered
	 */
	public function get(string $resourceSlug): EntityConfig
	{
		$config = $this->find($resourceSlug);

		if (!$config) {
			throw new RuntimeException('No entity registered for resource slug "' . $resourceSlug . '".');
		}

		return $config;
	}

	/**
	 * Config for a resource slug, falling back to the "base" entity.
	 *
	 * This preserves the long-standing LaraEntity behaviour of degrading to the
	 * base configuration rather than failing when a slug is unknown.
	 */
	public function findOrBase(string $resourceSlug): ?EntityConfig
	{
		return $this->find($resourceSlug) ?? $this->find('base');
	}

	/**
	 * The Eloquent model for a resource slug, for call sites that still read
	 * raw columns.
	 */
	public function model(string $resourceSlug): ?Entity
	{
		return $this->entities()[$resourceSlug] ?? null;
	}

	/**
	 * @return array<string, EntityConfig> keyed by resource slug
	 */
	public function all(): array
	{
		foreach (array_keys($this->entities()) as $slug) {
			$this->find($slug);
		}

		return $this->configs;
	}

	/**
	 * Token that changes whenever entity configuration changes.
	 *
	 * Append this to any cache key holding a value derived from entity config.
	 */
	public function version(): string
	{
		if ($this->version !== null) {
			return $this->version;
		}

		return $this->version = Cache::rememberForever(
			self::VERSION_KEY,
			static fn(): string => (string) time(),
		);
	}

	/**
	 * Drop the cached configuration and invalidate everything derived from it.
	 */
	public function flush(): void
	{
		$this->entities = null;
		$this->configs = [];
		$this->version = null;

		Cache::forget(self::CACHE_KEY);
		Cache::forever(self::VERSION_KEY, (string) microtime(true));
	}

	/**
	 * @return array<string, Entity> keyed by resource slug
	 */
	private function entities(): array
	{
		if ($this->entities !== null) {
			return $this->entities;
		}

		$cached = Cache::get(self::CACHE_KEY);

		if (is_array($cached) && $cached !== []) {
			return $this->entities = $cached;
		}

		$loaded = $this->load();

		// An empty result means the table is missing or not seeded yet, i.e. the
		// application still needs setup. Caching that forever would survive the
		// setup run, and the seeders insert with the query builder so no model
		// event fires to flush it. Only a non-empty result is worth caching.
		if ($loaded === []) {
			return [];
		}

		Cache::forever(self::CACHE_KEY, $loaded);

		return $this->entities = $loaded;
	}

	/**
	 * Read every entity row from the database.
	 *
	 * Protected so a test can substitute the "nothing there yet" result without
	 * having to drop or empty the table.
	 *
	 * @return array<string, Entity> keyed by resource slug
	 */
	protected function load(): array
	{
		try {
			$entities = Entity::with(self::RELATIONS)->get();
		} catch (QueryException) {
			// the table does not exist yet
			return [];
		}

		$keyed = [];

		foreach ($entities as $entity) {
			if (!empty($entity->resource_slug)) {
				$keyed[$entity->resource_slug] = $entity;
			}
		}

		return $keyed;
	}

}
