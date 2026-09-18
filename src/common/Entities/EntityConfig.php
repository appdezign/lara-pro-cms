<?php

namespace Lara\Common\Entities;

use Illuminate\Support\Collection;
use Lara\Common\Entities\Config\ContentOptions;
use Lara\Common\Entities\Config\DisplayOptions;
use Lara\Common\Entities\Config\FilterOptions;
use Lara\Common\Entities\Config\MediaOptions;
use Lara\Common\Entities\Config\RelationOptions;
use Lara\Common\Entities\Config\SortOptions;
use Lara\Common\Models\Entity;

/**
 * Immutable view of one lara_resource_entities row.
 *
 * Built from an Entity model by EntityRegistry. Constructing one does no I/O,
 * so it is safe to create per request, per controller, or in a test without a
 * database. The grouped option objects mirror the column prefixes in the table.
 *
 * The originating Entity model stays reachable via model() for the call sites
 * that still read raw columns directly.
 */
final readonly class EntityConfig
{

	public function __construct(
		public int $id,
		public string $resourceSlug,
		public ?string $title,
		public ?string $labelSingle,
		public ?string $cgroup,
		public ?string $navGroup,
		public int $navPosition,
		public bool $hasFrontAuth,
		public ?string $resourceClass,
		public ?string $modelClass,
		public ?string $policyClass,
		public ?string $controller,
		public ContentOptions $content,
		public DisplayOptions $display,
		public FilterOptions $filters,
		public MediaOptions $media,
		public RelationOptions $relations,
		public SortOptions $sort,
		private Entity $entity,
	) {}

	public static function fromEntity(Entity $entity): self
	{
		return new self(
			id: (int) $entity->id,
			resourceSlug: (string) $entity->resource_slug,
			title: $entity->title,
			labelSingle: $entity->label_single,
			cgroup: $entity->cgroup,
			navGroup: $entity->nav_group,
			navPosition: (int) $entity->position,
			hasFrontAuth: (bool) $entity->has_front_auth,
			resourceClass: $entity->resource,
			modelClass: $entity->model_class,
			policyClass: $entity->policy,
			controller: $entity->controller,
			content: ContentOptions::fromEntity($entity),
			display: DisplayOptions::fromEntity($entity),
			filters: FilterOptions::fromEntity($entity),
			media: MediaOptions::fromEntity($entity),
			relations: RelationOptions::fromEntity($entity),
			sort: SortOptions::fromEntity($entity),
			entity: $entity,
		);
	}

	/**
	 * The underlying Eloquent model.
	 *
	 * Prefer the typed properties above. This exists for the call sites that
	 * still read raw columns or need the custom field / view / relation
	 * relationships.
	 */
	public function model(): Entity
	{
		return $this->entity;
	}

	/**
	 * @return Collection<int, \Lara\Common\Models\EntityCustomField>
	 */
	public function customFields(): Collection
	{
		return $this->entity->customfields;
	}

	/**
	 * @return Collection<int, \Lara\Common\Models\EntityView>
	 */
	public function views(): Collection
	{
		return $this->entity->views;
	}

	/**
	 * @return Collection<int, \Lara\Common\Models\EntityRelation>
	 */
	public function entityRelations(): Collection
	{
		return $this->entity->relations;
	}

}
