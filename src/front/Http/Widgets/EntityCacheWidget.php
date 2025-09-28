<?php

namespace Lara\Front\Http\Widgets;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

use Lara\Common\Models\Tag;

use Arrilot\Widgets\AbstractWidget;

use LaravelLocalization;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontRoutes;
use Lara\Front\Http\Concerns\HasFrontTerms;

use Carbon\Carbon;

class EntityCacheWidget extends AbstractWidget
{

	use hasFrontend;
	use HasFrontEntity;
	use HasFrontRoutes;
	use HasFrontTerms;

	protected $config = [
		'resource_slug' => null,
		'parent'        => null,
		'term'          => null,
		'filterfield'   => null,
		'filterval'     => null,
		'needs_image'   => true,
		'count'         => 0,
		'title'         => null,
		'grid'          => null,
		'sortfield'     => null,
		'sortorder'     => null,
		'exclude'       => null,
		'since'         => null,
		'ignore_hide'   => false,
	];

	public $cacheTime = false;

	public function __construct(array $config = [])
	{
		$this->cacheTime = config('lara-front.widget_cache_time');
		parent::__construct($config);
	}

	public function cacheKey(array $params = [])
	{

		$language = LaravelLocalization::getCurrentLocale();

		$cachekey = 'lara.widgets.entity.' . $this->config['parent'] . '.' . $this->config['resource_slug'] . '.' . $language;

		if ($this->config['term']) {
			$cachekey = $cachekey . '.' . $this->config['term'];
		}

		if ($this->config['sortfield']) {
			$cachekey = $cachekey . '.' . $this->config['sortfield'];
		}

		return $cachekey;

	}

	/**
	 * @return Application|Factory|View
	 */
	public function run()
	{

		$language = LaravelLocalization::getCurrentLocale();

		$isMultiLanguage = config('lara.is_multi_language');

		$entity = $this->getResourceBySlug($this->config['resource_slug']);

		if ($entity) {

			$term = $this->config['term'];
			$filterfield = $this->config['filterfield'];
			$filtervalue = $this->config['filterval'];

			if ($term) {

				if ($isMultiLanguage) {
					$activeTerm = $term . '-' . $language;
				} else {
					$activeTerm = $term;
				}

				// get the full Tag object
				$widgetTaxonomy = Tag::langIs($language)
					->resourceIs($entity->getResourceSlug())
					->where('slug', $activeTerm)->first();
				if (empty($widgetTaxonomy)) {
					$term = null;
					$activeTerm = null;
				}
			} else {
				$widgetTaxonomy = null;
			}

			// start collection
			$modelClass = $entity->getEntityModelClass();
			$collection = new $modelClass;

			$collection = $collection->langIs($language);

			if ($this->config['exclude']) {
				$collection = $collection->where('id', '!=', $this->config['exclude']);
			}

			if ($this->config['since']) {
				$days = $this->config['since'];
				$collection = $collection->where('created_at', '>', Carbon::now()->subDays($days)->toDateTimeString());
			}

			if ($entity->hasStatus()) {
				$collection = $collection->isPublished();
			}

			if ($entity->hasHideinlist()) {
				if (!$this->config['ignore_hide']) {
					$collection = $collection->where('publish_hide', 0);
				}
			}

			if ($entity->hasExpiration()) {
				$collection = $collection->isNotExpired();
			}

			if (method_exists($modelClass, 'scopeFront')) {
				$collection = $collection->front();
			}

			if ($this->config['needs_image']) {
				$collection = $collection->has('images');
			}

			if ($entity->hasImages()) {
				$collection = $collection->with('images');
			}

			if ($term) {
				$collection = $collection->whereHas('terms', function ($query) use ($activeTerm) {
					$query->where(config('lara-common.database.object.terms') . '.slug', $activeTerm);
				});

			} else {

				if ($filterfield && $filtervalue) {
					$collection = $collection->where($filterfield, $filtervalue);
				}

				$collection = $collection->with([
					'tags' => function ($query) use ($entity) {
						$query->where(config('lara-common.database.object.terms') . '.resource_slug', $entity->getResourceSlug());
					},
				]);
			}

			if ($this->config['sortfield'] && $this->config['sortorder']) {

				$collection = $collection->orderBy($this->config['sortfield'], $this->config['sortorder']);

			} else {

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
			}

			if (is_numeric($this->config['count']) && $this->config['count'] > 0) {
				$collection = $collection->limit($this->config['count']);
			}

			// get collection
			$widgetObjects = $collection->get();

			// get all tags
			if ($entity->hasTags()) {
				$widgetTaxonomies = $this->getTagsFromCollection($language, $entity, $widgetObjects);
			} else {
				$widgetTaxonomies = null;
			}

			$widgetEntityRoute = $this->getFrontSeoRoute($entity->getResourceSlug(), 'index');

		} else {

			dd($this->config['resource_slug']);

			$widgetObjects = null;
			$widgetTaxonomy = null;
			$widgetTaxonomies = null;
			$widgetEntityRoute = null;

		}

		// identifier
		$templateFileName = $this->config['parent'] . '_' . $this->config['resource_slug'];

		// Template
		$widgetview = '_widgets.entity.' . $templateFileName;

		if (view()->exists($widgetview)) {

			return view($widgetview, [
				'config'            => $this->config,
				'grid'              => $this->config['grid'],
				'widgetObjects'     => $widgetObjects,
				'widgetTerm'        => $term,
				'widgetTaxonomy'    => $widgetTaxonomy,
				'widgetTaxonomies'  => $widgetTaxonomies,
				'widgetEntityRoute' => $widgetEntityRoute,
				'widgetTitle'       => $this->config['title'],
			]);

		} else {
			$errorView = (config('app.env') == 'production') ? 'not_found_prod' : 'not_found';

			return view('_widgets._error.' . $errorView, [
				'widgetview' => $widgetview,
			]);
		}

	}

}
