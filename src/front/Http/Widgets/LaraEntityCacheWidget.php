<?php

namespace Lara\Front\Http\Widgets;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

use Lara\Common\Models\Tag;
use Lara\Common\Models\LaraWidget;

use Arrilot\Widgets\AbstractWidget;

use LaravelLocalization;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontRoutes;
use Lara\Front\Http\Concerns\HasFrontTerms;

class LaraEntityCacheWidget extends AbstractWidget
{

	use hasFrontend;
	use HasFrontEntity;
	use HasFrontRoutes;
	use HasFrontTerms;

	protected $config = [
		'widget_id' => null,
		'grid'      => null,
	];

	public $cacheTime = false;

	public function __construct(array $config = [])
	{
		$this->cacheTime = config('lara-front.widget_cache_time');
		parent::__construct($config);
	}

	public function cacheKey(array $params = [])
	{
		return 'lara.widgets.entity.' . $this->config['widget_id'];
	}

	/**
	 * @return Application|Factory|View
	 */
	public function run()
	{

		$language = LaravelLocalization::getCurrentLocale();

		$larawidget = LaraWidget::find($this->config['widget_id']);

		$resourceSlug = $larawidget->resource_slug;
		$entity = $this->getResourceBySlug($resourceSlug);

		if ($entity) {

			$term = ($larawidget->term != 'none') ? $larawidget->term : null;

			if ($term) {
				// get the full Tag object
				$taxonomy = $this->getFrontDefaultTaxonomy();
				$widgetTaxonomy = Tag::langIs($language)
					->entityIs($entity->getResourceSlug())
					->taxonomyIs($taxonomy->id)
					->where('slug', $term)->first();
				if (empty($widgetTaxonomy)) {
					$term = null;
				}
			} else {
				$widgetTaxonomy = null;
			}

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

			if (method_exists($modelClass, 'scopeFront')) {
				$collection = $collection->front();
			}

			if ($larawidget->imgreq) {
				$collection = $collection->has('images');
			}

			if ($entity->hasImages()) {
				$collection = $collection->with('images');
			}

			if ($term) {
				$collection = $collection->whereHas('terms', function ($query) use ($term) {
					$query->where(config('lara-common.database.object.terms') . '.slug', $term);
				});

			} else {
				$collection = $collection->with([
					'tags' => function ($query) use ($entity) {
						$query->where(config('lara-common.database.object.terms') . '.resource_slug', $entity->getResourceSlug());
					},
				]);
			}

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

			if (is_numeric($larawidget->max_items) && $larawidget->max_items > 0) {
				$collection = $collection->limit($larawidget->max_items);
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

			$widgetObjects = null;
			$widgetTaxonomy = null;
			$widgetTaxonomies = null;
			$widgetEntityRoute = null;

		}

		// identifier
		if ($larawidget->template) {
			$templateFileName = $larawidget->template;
		} else {
			$templateFileName = 'default_' . $resourceSlug;
		}

		$widgetview = '_widgets.lara.entity.' . $templateFileName;

		if (view()->exists($widgetview)) {

			return view($widgetview, [
				'config'            => $this->config,
				'grid'              => $this->config['grid'],
				'widgetObjects'     => $widgetObjects,
				'widgetTaxonomy'    => $widgetTaxonomy,
				'widgetTaxonomies'  => $widgetTaxonomies,
				'widgetEntityRoute' => $widgetEntityRoute,
				'larawidget'        => $larawidget,
			]);

		} else {
			$errorView = (config('app.env') == 'production') ? 'not_found_prod' : 'not_found';

			return view('_widgets._error.' . $errorView, [
				'widgetview' => $widgetview,
			]);
		}

	}

}
