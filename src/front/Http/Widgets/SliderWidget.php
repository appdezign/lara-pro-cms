<?php

namespace Lara\Front\Http\Widgets;

use Arrilot\Widgets\AbstractWidget;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Lara\Common\Models\Tag;

use LaravelLocalization;

use Lara\Front\Http\Concerns\HasFrontTerms;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\hasFrontend;

class SliderWidget extends AbstractWidget
{

	use hasFrontend;
	use HasFrontEntity;
	use HasFrontTerms;

	protected $config = [
		'term'        => 'home',
		'grid'        => null,
		'sliderclass' => null,
	];

	public $cacheTime = false;

	public function __construct(array $config = [])
	{
		$this->cacheTime = config('lara-front.widget_cache_time');
		parent::__construct($config);
	}

	public function cacheKey(array $params = [])
	{
		return 'lara.widgets.sliderWidget.' . $this->config['term'];
	}

	/**
	 * @return Application|Factory|View
	 */
	public function run()
	{

		$language = LaravelLocalization::getCurrentLocale();

		$isMultiLanguage = config('lara.is_multi_language');

		$term = $this->config['term'];

		if ($isMultiLanguage) {
			$activeTerm = $term . '-' . $language;
		} else {
			$activeTerm = $term;
		}

		$taxonomy = $this->getFrontDefaultTaxonomy();
		$tag = Tag::langIs($language)
			->resourceIs('sliders')
			->taxonomyIs($taxonomy->id)
			->where('slug', $activeTerm)->first();

		if ($tag) {

			$entity = $this->getResourceBySlug('sliders');
			$modelClass = $entity->getEntityModelClass();

			// get sliders
			$widgetsliders = $modelClass::langIs($language)
				->isPublished()
				->has('images')
				->whereHas('terms', function ($query) use ($activeTerm) {
					$query->where(config('lara-common.database.object.terms') . '.slug', $activeTerm);
				})
				->orderBy($entity->getPrimarySortField(), $entity->getPrimarySortOrder())
				->get();

		} else {

			$widgetsliders = null;

		}

		// identifier
		$templateFileName = $this->config['term'];

		$widgetview = '_widgets.slider.' . $templateFileName;

		if (view()->exists($widgetview)) {

			return view($widgetview, [
				'config'        => $this->config,
				'grid'          => $this->config['grid'],
				'sliderclass'   => $this->config['sliderclass'],
				'widgetsliders' => $widgetsliders,
			]);

		} else {
			$errorView = (config('app.env') == 'production') ? 'not_found_prod' : 'not_found';
			return view('_widgets._error.' . $errorView, [
				'widgetview' => $widgetview,
			]);
		}

	}

}
