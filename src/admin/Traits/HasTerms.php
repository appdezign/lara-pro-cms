<?php

namespace Lara\Admin\Traits;

use Lara\Common\Models\Entity;
use Lara\Common\Models\Taxonomy;
use Lara\Common\Models\Tag;

trait HasTerms
{

	/**
	 * @param $language
	 * @param $resource_slug
	 * @param $taxonomy_id
	 * @return void
	 */
	private static function processTagNodes($language, $resource_slug, $taxonomy_id): void
	{
		$entity = Entity::where('resource_slug', $resource_slug)->first();

		$taxonomy = Taxonomy::find($taxonomy_id);

		if ($entity) {

			$collection = Tag::scoped(['resource_slug' => $resource_slug, 'language' => $language, 'taxonomy_id' => $taxonomy->id])
				->defaultOrder()
				->get();

			$tree = $collection->toTree();

			foreach ($tree as $node) {
				static::processTagNode($node, $taxonomy->has_hierarchy);
			}

			// save sort order
			$array = $collection->toArray();
			$position = $taxonomy->id * 100000 + $entity->id * 1000 + 1;
			foreach ($array as $item) {
				$tagId = $item['id'];
				$tag = Tag::find($tagId);
				$tag->position = $position;
				$tag->save();
				$position++;
			}

		}
	}

	/**
	 * @param object $node
	 * @param bool $hasHierarchy
	 * @param string|null $parentRoute
	 * @return void
	 */
	private static function processTagNode(object $node, bool $hasHierarchy = false, ?string $parentRoute = null): void
	{

		// depth
		$node->depth = sizeof($node->ancestors);

		// route
		if ($node->depth == 0) {
			$node->route = $node->slug;
		} else {
			$node->route = $parentRoute . '.' . $node->slug;
		}

		$node->save();

		foreach ($node->children as $child) {
			static::processTagNode($child, $hasHierarchy, $node->route);
		}

	}
}
