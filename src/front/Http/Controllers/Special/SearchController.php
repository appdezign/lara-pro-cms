<?php

namespace Lara\Front\Http\Controllers\Special;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

use Illuminate\View\View;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontList;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontObject;
use Lara\Front\Http\Concerns\HasFrontRoutes;
use Lara\Front\Http\Concerns\hasTheme;
use Lara\Front\Http\Concerns\HasFrontView;

use Jenssegers\Agent\Agent;

use Lara\Common\Models\Entity;
use Lara\Common\Models\Menu;
use Lara\Common\Models\MenuItem;

use LaravelLocalization;

use stdClass;

class SearchController extends Controller
{

	use hasFrontend;
	use HasFrontEntity;
	use HasFrontList;
	use HasFrontMenu;
	use HasFrontObject;
	use HasFrontRoutes;
	use hasTheme;
	use HasFrontView;

	/**
	 * @var string|null
	 */
	protected $routename;

	/**
	 * @var object
	 */
	protected $entity;

	/**
	 * @var string
	 */
	protected $language;

	/**
	 * @var object
	 */
	protected $data;

	/**
	 * @var bool
	 */
	protected $ismobile;

	/**
	 * @var object
	 */
	protected $globalwidgets;

	public function __construct()
	{

		// get language
		$this->language = LaravelLocalization::getCurrentLocale();

		// create an empty Laravel object to hold all the data (see: https://goo.gl/ufmFHe)
		$this->data = new stdClass;

		if (!App::runningInConsole()) {

			// get route name
			$this->routename = Route::current()->getName();

			// get entity
			$this->entity = $this->getFrontEntity($this->routename);

			// get active route
			$this->activeroute = $this->getLaraActiveRoute($this->routename);

			// get default seo
			$this->data->seo = $this->getDefaultSeo($this->language);

			// get default layout
			$this->data->layout = $this->getDefaultThemeLayout();
			$this->data->grid = $this->getGrid($this->data->layout);

			// get global widgets
			$this->globalwidgets = $this->getGlobalWidgets($this->language);

			// get agent
			$agent = new Agent();
			$this->ismobile = $agent->isMobile();

			// share data with all views, see: https://goo.gl/Aqxquw
			$this->middleware(function ($request, $next) {
				view()->share('entity', $this->entity);
				view()->share('activeroute', $this->activeroute);
				view()->share('language', $this->language);
				view()->share('ismobile', $this->ismobile);
				view()->share('globalwidgets', $this->globalwidgets);
				view()->share('firstpageload', $this->getFirstPageLoad());

				return $next($request);
			});

		}

	}

	/**
	 * @return Application|Factory|View
	 */
	public function form()
	{

		// get language versions
		$this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity);

		$viewfile = '_search.form';

		return view($viewfile, [
			'data' => $this->data,
		]);

	}

	/**
	 * @param Request $request
	 * @return Application|Factory|View
	 */
	public function result(Request $request)
	{

		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);

		$this->data->results = new stdClass;

		$this->data->singleEntity = null;

		if ($request->has('keywords')) {

			$mainMenuID = $this->getMainMenuId();

			$entities = MenuItem::distinct('entity_id')
				->langIs($this->language)
				->menuIs($mainMenuID)
				->where('type', 'page')
				->orWhere('type', 'entity')
				->where('publish', 1)
				->pluck('entity_id');

			foreach ($entities as $entity_id) {

				$entity = Entity::find($entity_id);
				$resource_slug = $entity->resource_slug;

				$laraEntity = $this->getResourceBySlug($resource_slug);

				$collection = $entity->model_class::langIs($this->language);

				// filter by search keywords
				$this->data->keywords = $request->get('keywords');
				$keywords = $this->cleanupFrontSearchString($this->data->keywords);

				if ($resource_slug == 'page') {
					$collection = $collection->whereNotNull('menuroute');
				}

				$collection = $collection->where(function ($q) use ($entity, $keywords) {
					foreach ($keywords as $value) {

						$entityKey = $entity->resource_slug;
						$entitySearchFields = config('lara-front.entity_search_fields');
						if(key_exists($entityKey, $entitySearchFields)) {
							// custom search fields
							$customSearchFields = $entitySearchFields[$entityKey];
							foreach($customSearchFields as $customSearchField) {
								$q->orWhere($customSearchField, 'like', "%{$value}%");
							}
						} else {
							// default search fields (title, lead, body)
							$q->orWhere('title', 'like', "%{$value}%");
							if ($entity->col_has_lead) {
								$q->orWhere('lead', 'like', "%{$value}%");
							}
							if ($entity->col_has_body) {
								$q->orWhere('body', 'like', "%{$value}%");
							}
						}
					}
				});

				if($laraEntity->hasStatus()) {
					$collection = $collection->where('publish', 1);
				}

				if ($resource_slug != 'pages') {
					if ($laraEntity->getPrimarySortField()) {
						$collection = $collection->orderBy($laraEntity->getPrimarySortField(), $laraEntity->getPrimarySortOrder());
					}
					if ($laraEntity->getSecondarySortField()) {
						$collection = $collection->orderBy($laraEntity->getSecondarySortField(), $laraEntity->getSecondarySortOrder());
					}
				}

				$objects = $collection->get();

				// get menu urls
				foreach ($objects as $object) {
					$object->routename = $this->getFrontSeoRoute($resource_slug, 'index', true);

				}

				$this->data->results->$resource_slug = new stdClass;
				$this->data->results->$resource_slug->entity = $laraEntity;
				$this->data->results->$resource_slug->objects = $objects;

			}

		} else {

			$this->data->keywords = null;
			$this->data->results = [];

		}

		// get language versions
		$this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity);

		$viewfile = '_search.result';

		return view($viewfile, [
			'data' => $this->data,
		]);

	}

	public function modresult(Request $request, $module)
	{

		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);

		$this->data->results = new stdClass;

		$this->data->singleEntity = null;

		if ($request->has('keywords')) {

			$singleEntity = Entity::where('resource_slug', $module)->first();

			$mainMenuID = $this->getMainMenuId();

			$ent = MenuItem::distinct('entity_id')
				->langIs($this->language)
				->menuIs($mainMenuID)
				->where('type', 'entity')
				->where('entity_id', $singleEntity->id)
				->first();

			if ($ent) {

				$entity = Entity::find($ent->entity_id);
				$resource_slug = $entity->getResourceSlug();

				$laraEntity = $this->getResourceBySlug($resource_slug);

				$this->data->singleEntity = $laraEntity;

				$collection = $entity->getEntityModelClass()::langIs($this->language);

				// filter by search keywords
				$this->data->keywords = $request->get('keywords');
				$keywords = $this->cleanupFrontSearchString($this->data->keywords);

				$collection = $collection->where(function ($q) use ($entity, $keywords) {
					foreach ($keywords as $value) {
						$entityKey = $entity->getResourceSlug();
						$entitySearchFields = config('lara-front.entity_search_fields');
						if(key_exists($entityKey, $entitySearchFields)) {
							// custom search fields
							$customSearchFields = $entitySearchFields[$entityKey];
							foreach($customSearchFields as $customSearchField) {
								$q->orWhere($customSearchField, 'like', "%{$value}%");
							}
						} else {
							// default search fields (title, lead, body)
							$q->orWhere('title', 'like', "%{$value}%");
							if ($entity->columns->has_lead) {
								$q->orWhere('lead', 'like', "%{$value}%");
							}
							if ($entity->columns->has_body) {
								$q->orWhere('body', 'like', "%{$value}%");
							}
						}
					}
				});

				if($laraEntity->hasStatus()) {
					$collection = $collection->where('publish', 1);
				}

				$objects = $collection->get();

				// get menu urls
				foreach ($objects as $object) {
					$object->routename = $this->getFrontSeoRoute($resource_slug, 'index', true);
				}

				$this->data->results->$resource_slug = new stdClass;
				$this->data->results->$resource_slug->entity = $laraEntity;
				$this->data->results->$resource_slug->objects = $objects;

			}

		}

		// get language versions
		$this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity);

		$viewfile = '_search.result';

		return view($viewfile, [
			'data' => $this->data,
		]);

	}

}
