<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Lara\Common\Models\Tag;
use Lara\Common\Models\Taxonomy;
use Lara\Front\Http\Lara\FrontParams;
use Lara\Front\Http\Lara\FrontPagination;
use Lara\Front\Http\Lara\FrontActiveRoute;
use Lara\Front\Http\Lara\FrontSortFields;
use stdClass;

trait HasFrontList
{

	/**
	 * Build the collection for the index method
	 *
	 * @param Request $request
	 * @param string $language
	 * @param object $entity
	 * @param FrontActiveRoute $activeroute
	 * @param Tag|null $menutaxonomy
	 * @param FrontParams|null $params
	 * @return mixed
	 */
	private function getFrontObjects(Request $request, string $language, object $entity, FrontActiveRoute $activeroute, Tag|null $menutaxonomy = null, FrontParams $params = null)
	{

		$method = $activeroute->getMethod();

		$view = $entity->getViews()->where('method', $method)->first();

		// start collection
		$modelClass = $entity->getEntityModelClass();
		$collection = new $modelClass;

		$collection = $collection->langIs($language);

		if ($entity->hasStatus()) {
			if ($this->getTestMode($request) == 'showall') {
				$collection = $collection->whereIn('publish', [0, 1]);
			} else {
				$collection = $collection->isPublished();
			}
		}

		if ($entity->hasHideinlist()) {
			$collection = $collection->where('publish_hide', 0);
		}

		if ($entity->hasExpiration()) {
			$collection = $collection->isNotExpired();
		}

		if ($view->image_required) {
			$collection = $collection->has('images');
		}

		// front scope
		$collection = $this->applyFrontScope($request, $entity, $collection);

		// filter by term
		$collection = $this->filterByTerm($entity, $collection, $view, $activeroute, $menutaxonomy, $params);

		// eager loading: user
		if ($entity->showAuthor()) {
			$collection = $collection->with('user');
		}

		// eager loading
		if ($entity->hasImages()) {
			$collection = $collection->with('images');
		}
		if ($entity->hasVideos()) {
			$collection = $collection->with('videos');
		}
		if ($entity->hasVideoFiles()) {
			$collection = $collection->with('videofiles');
		}
		if ($entity->hasFiles()) {
			$collection = $collection->with('files');
		}

		// OrderBy
		$collection = $this->applySortOrder($collection, $entity);

		// Sort list by Tags
		if ($view->showtags == '_sortbytaxonomy') {

			return $this->getFrontObjectsSortedByTaxonomy($language, $entity, $collection, $menutaxonomy, $params);

		} else {

			// Apply pagination (or get)
			$objects = $this->applyPagination($collection, $entity, $view);

			return $this->prepareRouteVars($objects, $menutaxonomy);

		}

	}



	/**
	 * @param object $entity
	 * @param object $view
	 * @return FrontPagination
	 */
	private function getEntityPagination(object $entity, object $view)
	{

		$listVars = new frontPagination;

		$override = $this->getFrontOverride($entity);

		if ($override && $override->paginate) {

			// custom pagination
			if ($override->paginate > 0) {
				$listVars->setPaginate(true);
				$listVars->setPagination($override->paginate);
			} else {
				if ($override->limit) {
					$listVars->setLimit($override->limit);
				}
			}

		} else {

			// entity view pagination
			if ($view->paginate > 0) {
				$listVars->setPaginate(true);
				$listVars->setPagination($view->paginate);
			} else {
				if ($override && $override->limit) {
					$listVars->setLimit($override->limit);
				}
			}
		}

		return $listVars;
	}

	/**
	 * @param object $collection
	 * @param object $entity
	 * @param object $view
	 * @return mixed
	 */
	private function applyPagination(object $collection, object $entity, object $view)
	{

		$listVars = $this->getEntityPagination($entity, $view);

		if($listVars->getPaginate()) {
			$objects = $collection->paginate($listVars->getPagination());
		} else {
			if($listVars->getLimit()) {
				$objects = $collection->limit($listVars->getLimit())->get();
			} else {
				$objects = $collection->get();
			}
		}

		return $objects;
	}

	/**
	 * @param object $collection
	 * @param object $entity
	 * @return object
	 */
	private function applySortOrder(object $collection, object $entity, bool $reverse = false)
	{

		$sortFields = $this->getSortFields($entity);

		$primaryOrder = $sortFields->getPrimaryOrder();
		$secondaryOrder = $sortFields->getSecondaryOrder();

		// we use the reverse order for getting the previous object in the show method
		if($reverse) {
			$primaryOrder = ($primaryOrder == 'asc') ? 'desc' : 'asc';
			$secondaryOrder = ($secondaryOrder == 'asc') ? 'desc' : 'asc';
		}

		if ($sortFields->getPrimaryField()) {
			$collection = $collection->orderBy($sortFields->getPrimaryField(), $primaryOrder);
		}

		if ($sortFields->getSecondaryField()) {
			$collection = $collection->orderBy($sortFields->getSecondaryField(), $secondaryOrder);
		}

		return $collection;
	}

	/**
	 * @param $entity
	 * @return FrontSortFields
	 */
	private function getSortFields($entity): FrontSortFields
	{

		$sortFields = new FrontSortFields;

		$override = $this->getFrontOverride($entity);

		if ($override && $override->primary_sortfield && $override->primary_sortorder) {

			$sortFields->setPrimaryField($override->primary_sortfield);
			$sortFields->setPrimaryOrder($override->primary_sortorder);

			if (isset($override->secondary_sortfield) && isset($override->secondary_sortorder)) {

				$sortFields->setSecondaryField($override->secondary_sortfield);
				$sortFields->setSecondaryOrder($override->secondary_sortorder);
			}

		} else {

			if ($entity->getPrimarySortField()) {
				$sortFields->setPrimaryField($entity->getPrimarySortField());
				$sortFields->setPrimaryOrder($entity->getPrimarySortOrder());
			}

			if ($entity->getSecondarySortField()) {
				$sortFields->setSecondaryField($entity->getSecondarySortField());
				$sortFields->setSecondaryOrder($entity->getSecondarySortOrder());
			}

		}

		return $sortFields;

	}

	/**
	 * @param Request $request
	 * @param object $entity
	 * @param object $collection
	 * @return object
	 */
	private function applyFrontScope(Request $request, object $entity, object $collection)
	{

		if (method_exists($entity->getEntityModelClass(), 'scopeFront')) {
			if ($this->getTestMode($request) != 'showall') {
				$collection = $collection->front();
			}
		}

		return $collection;

	}

	private function filterByTerm(object $entity, $collection, $view, FrontActiveRoute $activeroute, Tag|null $menutaxonomy = null, FrontParams $params = null)
	{

		if ($view->showtags == 'filterbytaxonomy') {

			if ($menutaxonomy) {

				// if the menu-item has a tag, then we overrule the other filters
				$collection = $collection->whereHas('terms', function ($query) use ($menutaxonomy) {
					$query->where(config('lara-common.database.object.terms') . '.id', $menutaxonomy->id);
				});

			} else {

				if ($activeroute->getActiveTags()) {

					$activeTags = $activeroute->getActiveTags();
					$term = end($activeTags);
					$excludeEntityTags = config('lara-eve.use_tags_for_sorting.' . $entity->getResourceSlug());
					$excludeTags = (!empty($excludeEntityTags)) ? $excludeEntityTags : [];
					if (!in_array($term, $excludeTags)) {
						$collection = $collection->whereHas('terms', function ($query) use ($term) {
							$query->where(config('lara-common.database.object.terms') . '.slug', $term);
						});
					}

				}

				if (!empty($params->getXtraTags())) {
					foreach ($params->getXtraTags() as $xtag) {
						$collection = $collection->whereHas('terms', function ($query) use ($xtag) {
							$query->where(config('lara-common.database.object.terms') . '.slug', $xtag['slug']);
						});
					}
				}
			}

		} else {

			if ($menutaxonomy) {
				$collection = $collection->whereHas('terms', function ($query) use ($menutaxonomy) {
					$query->where(config('lara-common.database.object.terms') . '.id', $menutaxonomy->id);
				});
			}

		}

		return $collection;
	}

	/**
	 * prepare route variables (master > detail)
	 */
	private function prepareRouteVars($objects, $menutaxonomy)
	{

		foreach ($objects as $obj) {
			if ($menutaxonomy) {
				$obj->routeVars = ['slug' => $obj->slug, $menutaxonomy->taxonomy->slug => $menutaxonomy->slug];
			} else {
				$obj->routeVars = ['slug' => $obj->slug];
			}
		}

		return $objects;
	}

	/**
	 * @param string $language
	 * @param object $entity
	 * @param object $collection
	 * @param Tag|null $menutaxonomy
	 * @param FrontParams|null $params
	 * @return stdClass|null
	 */
	private function getFrontObjectsSortedByTaxonomy(string $language, object $entity, object $collection, Tag|null $menutaxonomy = null, FrontParams $params = null)
	{

		// get active tag, if any
		if ($params->getFilterByTaxonomy()) {
			$taxonomy = Taxonomy::where('slug', $params->getTaxonomy())->first();
			$activetag = Tag::where('taxonomy_id', $taxonomy->id)->where('slug', $params->getFilterByTaxonomy())->first();
		} else {
			if ($menutaxonomy) {
				$activetag = $menutaxonomy;
			} else {
				$activetag = null;
			}
		}

		$tree = $this->getEntityTerms($language, $entity, $activetag);
		$objects = $collection->get();

		foreach ($tree as $taxonomy) {
			if ($taxonomy) {
				foreach ($taxonomy as $node) {
					$tagObjects = collect();
					foreach ($objects as $object) {
						if ($object->terms->contains($node->id)) {
							$tagObjects->add($object);
						}
					}

					$tagObjects = $this->prepareRouteVars($tagObjects, $menutaxonomy);

					$node->objects = $tagObjects;
				}
			}
		}

		return $tree;

	}

	/**
	 * @param $entity
	 * @return object|null
	 */
	private function getFrontOverride($entity)
	{

		$frontOverride = config('lara-eve.override_front_entity_objects');
		if (empty($frontOverride)) {
			return null;
		}

		if (array_key_exists($entity->getResourceSlug(), $frontOverride)) {
			$entityFrontOverride = $frontOverride[$entity->getResourceSlug()];

			return json_decode(json_encode($entityFrontOverride), false);
		} else {
			return null;
		}

	}

	/**
	 * Build the collection for a JSON feed
	 *
	 * @param string $language
	 * @param object $entity
	 * @param Request $request
	 * @param int|null $limit
	 * @return object
	 */
	private function getFeedObjects(string $language, object $entity, Request $request, $limit = null)
	{

		// start collection
		$modelClass = $entity->getEntityModelClass();
		$collection = new $modelClass;

		$collection = $collection->langIs($language);

		if ($entity->hasStatus()) {
			$collection = $collection->isPublished();
		}

		if (method_exists($entity->getEntityModelClass(), 'scopeFront')) {
			$collection = $collection->front();
		}

		if ($activeroute->getActiveTags()) {

			$activeTags = $activeroute->getActiveTags();
			$term = end($activeTags);

			$collection = $collection->whereHas('terms', function ($query) use ($term) {
				$query->where(config('lara-common.database.object.terms') . '.slug', $term);
			});

		}

		// eager loading: user
		if ($entity->getShowAuthor()) {
			$collection = $collection->with('user');
		}

		// OrderBy
		foreach ($entity->getCustomColumns() as $field) {
			if ($field->fieldname == 'sticky') {
				$collection = $collection->orderBy('sticky', 'desc');
			}
		}
		if ($entity->getPrimarySortField()) {
			$collection = $collection->orderBy($entity->getPrimarySortField(), $entity->getPrimarySortOrder());
		}
		if ($entity->getSecondarySortField()) {
			$collection = $collection->orderBy($entity->getSecondarySortField(), $entity->getSecondarySortOrder());
		}

		if ($limit && is_numeric($limit)) {
			$collection = $collection->limit($limit);
		}

		return $collection->get();

	}

	/**
	 * Get all objects for one specific tag
	 * The objects are added to the tag tree (nested set)
	 *
	 * @param object $node
	 * @param object $entity
	 * @param string $language
	 * @param bool $isGrid
	 * @return int
	 */
	private function getTagObjects(object $node, object $entity, string $language, bool $isGrid, $menutaxonomy = null)
	{

		$totalcount = 0;

		// get objects for this tag (skip root tag)

		$termId = $node->id;

		// start collection
		$collection = $entity->getEntityModelClass()::langIs($language)
			->isPublished()
			->when(($isGrid && $entity->getResourceSlug() != 'video'), function ($query) {
				return $query->has('images');
			});

		$collection = $collection->whereHas('terms', function ($query) use ($termId) {
			$query->where(config('lara-common.database.object.terms') . '.id', $termId);
		});

		if ($entity->hasHideinlist()) {
			$collection = $collection->where('publish_hide', 0);
		}

		if (method_exists($entity->getEntityModelClass(), 'scopeFront')) {
			$collection = $collection->front();
		}

		// eager loading: user
		if ($entity->showAuthor()) {
			$collection = $collection->with('user');
		}

		// eager loading: media
		if ($entity->hasImages()) {
			$collection = $collection->with('images');
		}

		// eager loading: files
		if ($entity->hasFiles() == 1) {
			$collection = $collection->with('files');
		}

		// OrderBy
		if ($entity->getPrimarySortField()) {
			$collection = $collection->orderBy($entity->getPrimarySortField(), $entity->getPrimarySortOrder());
		}
		if ($entity->getSecondarySortField()) {
			$collection = $collection->orderBy($entity->getSecondarySortField(), $entity->getSecondarySortOrder());
		}

		// get the collection
		$objects = $collection->get();

		// add object collection to node
		$node->objects = $objects;

		// add objectcount to node
		$node->objectcount = $node->objects->count();

		// prepare route variables (master > detail)
		foreach ($node->objects as $obj) {
			if ($menutaxonomy) {
				$obj->routeVars = ['slug' => $obj->slug, $menutaxonomy->taxonomy->slug => $menutaxonomy->slug];
			} else {
				$obj->routeVars = ['slug' => $obj->slug];
			}
		}

		// add objectcount from this tag to totalcount
		$totalcount = $node->objectcount;

		if (!$node->isLeaf()) {
			foreach ($node->children as $child) {
				$childobjectcount = $this->getTagObjects($child, $entity, $language, $isGrid, $menutaxonomy);

				// add child count to total count
				$totalcount = $totalcount + $childobjectcount;

			}
		}

		// add totalcount to node
		$node->childobjectcount = $totalcount;

		return $totalcount;
	}

	private function getPrevNextCollection(string $language, object $entity, FrontActiveRoute $activeroute, Tag|null $menutaxonomy = null, FrontParams $params = null, $reverse = false)
	{

		$view = $entity->getViews()->where('method', 'index')->first();

		// start collection
		$modelClass = $entity->getEntityModelClass();
		$collection = new $modelClass;

		$collection = $collection->langIs($language);

		if ($entity->hasStatus()) {
			$collection = $collection->isPublished();
		}

		if ($entity->hasHideinlist()) {
			$collection = $collection->where('publish_hide', 0);
		}

		if ($entity->hasExpiration()) {
			$collection = $collection->isNotExpired();
		}

		if ($view->image_required) {
			$collection = $collection->has('images');
		}

		// front scope
		if (method_exists($entity->getEntityModelClass(), 'scopeFront')) {
			$collection = $collection->front();
		}

		// filter by term
		$collection = $this->filterByTerm($entity, $collection, $view, $activeroute, $menutaxonomy, $params);

		// OrderBy
		return $this->applySortOrder($collection, $entity, $reverse);

	}

	/**
	 * Get the next object in a master detail structure (index/show)
	 *
	 * @param string $language
	 * @param object $entity
	 * @param FrontActiveRoute $activeroute
	 * @param object $object
	 * @param object $params
	 * @param $menutaxonomy
	 * @param $override
	 * @return mixed|null
	 */
	private function getNextObject(string $language, object $entity, FrontActiveRoute $activeroute, object $object, object $params, $menutaxonomy = null, $override = null)
	{

		$collection = $this->getPrevNextCollection($language, $entity, $activeroute, $menutaxonomy, $params);

		$sortFields = $this->getSortFields($entity);

		$primaryOperator = ($sortFields->getPrimaryOrder() == 'asc') ? '>' : '<';
		$primaryEqualOperator = ($sortFields->getPrimaryOrder() == 'asc') ? '>=' : '<=';
		$primarySortField = $sortFields->getPrimaryField();
		$primarySortValue = $object->$primarySortField;

		if ($sortFields->getSecondaryField()) {
			$secondaryOperator = ($sortFields->getSecondaryOrder() == 'asc') ? '>' : '<';
			$secondarySortField = $sortFields->getSecondaryField();
			$secondarySortValue = $object->$secondarySortField;
		}

		if ($sortFields->getSecondaryField()) {
			$collection = $collection
				->where($sortFields->getPrimaryField(), $primaryOperator, $primarySortValue)
				->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) use ($sortFields, $primaryEqualOperator, $primarySortValue, $secondaryOperator, $secondarySortValue) {
					$query->where($sortFields->getPrimaryField(), $primaryEqualOperator, $primarySortValue)
						->where($sortFields->getSecondaryField(), $secondaryOperator, $secondarySortValue);
				});
		} else {
			$collection = $collection->where($sortFields->getPrimaryField(), $primaryOperator, $primarySortValue);
		}

		return $collection->first();

	}

	/**
	 * Get the previous object in a master detail structure (index/show)
	 *
	 * @param string $language
	 * @param object $entity
	 * @param FrontActiveRoute $activeroute
	 * @param object $object
	 * @param object $params
	 * @param $menutaxonomy
	 * @param $override
	 * @return mixed|null
	 */
	private function getPrevObject(string $language, object $entity, FrontActiveRoute $activeroute, object $object, object $params, $menutaxonomy = null, $override = null)
	{

		$collection = $this->getPrevNextCollection($language, $entity, $activeroute, $menutaxonomy, $params, true);

		$sortFields = $this->getSortFields($entity);

		$primaryOperator = ($sortFields->getPrimaryOrder() == 'asc') ? '<' : '>';
		$primaryEqualOperator = ($sortFields->getPrimaryOrder() == 'asc') ? '<=' : '>=';
		$primarySortField = $sortFields->getPrimaryField();
		$primarySortValue = $object->$primarySortField;

		if ($sortFields->getSecondaryField()) {
			$secondaryOperator = ($sortFields->getSecondaryOrder() == 'asc') ? '<' : '>';
			$secondarySortField = $sortFields->getSecondaryField();
			$secondarySortValue = $object->$secondarySortField;
		}

		if ($sortFields->getSecondaryField()) {
			$collection = $collection
				->where($sortFields->getPrimaryField(), $primaryOperator, $primarySortValue)
				->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) use ($sortFields, $primaryEqualOperator, $primarySortValue, $secondaryOperator, $secondarySortValue) {
					$query->where($sortFields->getPrimaryField(), $primaryEqualOperator, $primarySortValue)
						->where($sortFields->getSecondaryField(), $secondaryOperator, $secondarySortValue);
				});
		} else {
			$collection = $collection->where($sortFields->getPrimaryField(), $primaryOperator, $primarySortValue);
		}

		return $collection->first();


	}

	/**
	 * Cleanup Search String
	 *
	 * @param string $str
	 * @return array|false|string[]
	 */
	private function cleanupFrontSearchString(string $str)
	{

		$keywords = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);

		return $keywords;

	}

	/**
	 * Get all parameters for the index method
	 * We need to pass several parameters to the view
	 *
	 * @param object $entity
	 * @param Request $request
	 * @return RedirectResponse|FrontParams
	 */
	private function getFrontParams(object $entity, FrontActiveRoute $activeroute, Request $request)
	{
		// NOTE: v10

		$params = new FrontParams;

		if ($entity->resource_slug == 'search') {

			$params->setListType('list');
			$params->setVType('list');
			$params->setShowTags('none');
			$params->setTagsView('default');

			return $params;

		}

		// get method
		$method = $activeroute->getMethod();
		if (empty($method)) {
			// set default method
			$method = ($entity->resource_slug == 'page') ? 'show' : 'index';
		}

		// get view
		$view = $entity->getViews()->where('method', $method)->first();
		if (empty($view)) {
			$view = $this->createDefaultView();
		}

		$params->setViewType($view->list_type);

		if (Str::contains($params->getViewType(), 'grid')) {
			$params->setIsGrid(true);
			$params->setListType('grid');
		} else {
			$params->setIsGrid(false);
			$params->setListType('list');
		}

		$params->setShowTags($view->showtags);

		if ($view->showtags == '_sortbytaxonomy') {
			$params->setTagsView('sort');

		} elseif ($view->showtags == 'filterbytaxonomy') {
			$params->setTagsView('filter');
		} else {
			$params->setTagsView('default');
		}

		if ($view->list_type == '_single') {

			$params->setVType('single');
			$params->setGridCols(0);
			$params->setGridCol(0);
			$params->setPrevNext((bool)$view->prevnext);

		} else {

			if ($params->getIsGrid()) {
				$params->setVType('grid');
				$params->setGridCols(substr($view->list_type, -1));
				$params->setGridCol((12 / $params->getGridCols()));
			} else {
				$params->setVType('list');
				$params->setGridCols(0);
				$params->setGridCol(0);
			}

		}

		if ($view->infinite == 1) {
			$params->setInfinite(true);
		} else {
			$params->setInfinite(false);
		}

		if ($view->showtags == '_sortbytaxonomy') {

			$params->setPaginate(false);

		} elseif ($view->showtags == 'filterbytaxonomy') {

			$hasPagination = $view->paginate > 0;
			$params->setPaginate($hasPagination);

		} else {

			$hasPagination = $view->paginate > 0;
			$params->setPaginate($hasPagination);

		}

		if ($view->showtags == 'filterbytaxonomy' || $view->showtags == '_sortbytaxonomy' || $view->list_type == '_single') {

			// primary tags (URL)
			if (!empty($activeroute->getActiveTags())) {
				$activeTags = $activeroute->getActiveTags();
				$term = end($activeTags);

				$tag = Tag::where('slug', $term)->first();
				$taxonomy = $tag->taxonomy;
				$params->setTaxonomy($taxonomy->slug);

				if ($taxonomy) {
					if ($taxonomy->is_default == 1) {
						$params->setIsDefaultTaxonomy(true);
					} else {
						$params->setIsDefaultTaxonomy(false);
					}
				}

			}

			if (!empty($term)) {
				$params->setFilter(true);
				$params->setFilterByTaxonomy($term);

			}

			// secondary tags (GET)
			$taxonomies = Taxonomy::where('is_default', 0)->get();
			foreach ($taxonomies as $taxonomy) {
				$taxonomySlug = $taxonomy->slug;
				$tagSlug = $this->getFrontRequestParam($request, $taxonomySlug, null, $entity->resource_slug, true);

				if ($tagSlug) {

					if ($view->showtags == 'filterbytaxonomy') {
						// redirect if tag is not in GET variables
						if (!isset($_GET[$taxonomySlug])) {
							return redirect()->route(Route::currentRouteName(), [$taxonomySlug => $tagSlug])->send();
						}
					}

					// get Tag object
					$tag = Tag::where('slug', $tagSlug)->first();
					if ($tag) {
						$params->setXtraTags($taxonomySlug, ['slug' => $tag->slug, 'title' => $tag->title]);
					}

				} else {

					if ($view->showtags == 'filterbytaxonomy') {
						// redirect if empty tag is in GET variables
						if (isset($_GET[$taxonomySlug]) && $_GET[$taxonomySlug] == '') {
							return redirect()->route(Route::currentRouteName())->send();
						}
					}

				}

			}
		}

		return $params;

	}

	/**
	 * Get the specified request parameter
	 *
	 * The fallback order is:
	 * - request
	 * - session
	 * - default
	 *
	 * A request parameter can be stored in the session globally,
	 * or it can be stored for the specific content entity
	 *
	 * @param Request $request
	 * @param string $param
	 * @param string|null $default
	 * @param string|null $resourceSlug
	 * @param bool $reset
	 * @return mixed
	 */
	private function getFrontRequestParam(Request $request, string $param, ?string $default = null, ?string $resourceSlug = null, bool $reset = false)
	{

		// NOTE: v10

		if ($resourceSlug) {

			// store request param for specific entity only
			if ($request->has($param) || $reset == true) {

				$value = $request->get($param);
				if (session()->has($resourceSlug)) {
					$entitySession = session($resourceSlug);
					$entitySession[$param] = $value;
					session([$resourceSlug => $entitySession]);
				} else {
					session([
						$resourceSlug => [
							$param => $value,
						],
					]);
				}

			} else {

				if (session()->has($resourceSlug)) {
					$entitySession = session($resourceSlug);
					if (array_key_exists($param, $entitySession)) {
						if (!empty($entitySession[$param])) {
							$value = $entitySession[$param];
						} else {
							$value = $default;
						}
					} else {
						$value = $default;
					}
				} else {
					$value = $default;
				}
			}

		} else {

			// store request param globally
			if ($request->has($param) || $reset) {
				$value = $request->get($param);
				session([$param => $value]);
			} else {
				if (session()->has($param)) {
					if (!empty(session($param))) {
						$value = session($param);
					} else {
						$value = $default;
					}
				} else {
					$value = $default;
				}
			}

		}

		// convert true/false strings to boolean
		if ($value == 'true') {
			return true;
		} elseif ($value == 'false') {
			return false;
		} else {
			return $value;
		}

	}

	/**
	 * @param string $language
	 * @param object $entity
	 * @param bool|null $activetag
	 * @return stdClass|null
	 */
	private function getEntityTerms(string $language, object $entity, bool|null $activetag = false)
	{
		if ($entity->hasTags()) {
			$tags = new stdClass();

			if ($activetag) {
				$taxonomies = Taxonomy::where('id', $activetag->taxonomy_id)->get();
			} else {
				$taxonomies = Taxonomy::get();
			}

			foreach ($taxonomies as $taxonomy) {

				$taxonomySlug = $taxonomy->slug;

				if ($activetag) {

					// get subtree
					$tags->$taxonomySlug = Tag::scoped(['resource_slug' => $entity->getResourceSlug(), 'language' => $language, 'taxonomy_id' => $taxonomy->id])
						->defaultOrder()
						->descendantsAndSelf($activetag->id)
						->toTree();

				} else {
					// get full tree
					$tags->$taxonomySlug = Tag::scoped(['resource_slug' => $entity->getResourceSlug(), 'language' => $language, 'taxonomy_id' => $taxonomy->id])
						->defaultOrder()
						->get()
						->toTree();
				}
			}

			return $tags;

		} else {
			return null;
		}

	}

	private function getTestMode($request)
	{

		if (Auth::check()) {
			if ($request->has('testkey') && $request->input('testkey') == config('lara.testkey')) {
				if ($request->has('testmode')) {
					return $request->input('testmode');
				} else {
					return null;
				}
			} else {
				return null;
			}
		} else {
			return null;
		}

	}

	/**
	 * @return stdClass
	 */
	private function createDefaultView()
	{
		$view = new stdClass;

		$view->method = 'show';
		$view->filename = 'show';
		$view->list_type = '_single';
		$view->showtags = 'none';
		$view->paginate = 0;
		$view->infinite = 0;
		$view->prevnext = 0;

		return $view;
	}

	/* deprecated
	private function getListObjectCount($objects, $params)
	{

		if ($params->getTagsView() == 'sort') {
			$objectCount = 0;
			foreach ($objects as $taxonomy => $terms) {
				foreach ($terms as $node) {
					if (array_key_exists('objects', $node->toArray())) {
						$objectCount = $objectCount + $node->objects->count();
					}
				}
			}
		} else {
			$objectCount = $objects->count();
		}

		return $objectCount;

	}
	*/

	private function setTaxonomyFilter($data)
	{

		if ($data->params->getShowTags() == 'filterbytaxonomy') {

			// overrule layout for tag menu in left sidebar
			$data->layout->content = 'boxed_sidebar_left_3';

			// get current tag
			$data->tag = $this->getTagBySlug($this->language, $this->entity, $data->params->getFilterByTaxonomy());

			// get current tag children
			$data->children = $this->getTagChildren($this->language, $this->entity, $data->params->getFilterByTaxonomy());

		} else {

			$data->tag = null;
			$data->children = null;

		}

		return $data;
	}
}
