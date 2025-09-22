<?php

namespace Lara\Front\Http\Controllers\Base;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontAuth;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontList;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontObject;
use Lara\Front\Http\Concerns\HasFrontRoutes;
use Lara\Front\Http\Concerns\HasFrontSecurity;
use Lara\Front\Http\Concerns\HasFrontTags;
use Lara\Front\Http\Concerns\hasTheme;
use Lara\Front\Http\Concerns\HasFrontView;

use Jenssegers\Agent\Agent;

use LaravelLocalization;

use ReflectionClass;
use ReflectionException;

use stdClass;

class BaseFrontController extends Controller
{

	use hasFrontend;
	use HasFrontAuth;
	use HasFrontEntity;
	use HasFrontList;
	use HasFrontMenu;
	use HasFrontObject;
	use HasFrontRoutes;
	use HasFrontSecurity;
	use HasFrontTags;
	use hasTheme;
	use HasFrontView;

	protected ?string $modelClass;
	protected ?string $routename;
	protected ?object $entity;
	protected ?object $activeroute;
	protected ?string $language;
	protected ?object $data;
	protected ?object $globalwidgets;
	protected bool $ismobile;

	public function __construct()
	{

		// get model class from child controller
		$this->modelClass = $this->determineModelClass();

		// get language
		$this->language = LaravelLocalization::getCurrentLocale();

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

			// get entity routes from menu
			$this->data->eroutes = $this->getMenuEntityRoutes($this->language);

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
				view()->share('activemenu', $this->getActiveMenuArray());
				view()->share('firstpageload', $this->getFirstPageLoad());

				return $next($request);
			});

		}

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return Application|Factory|View
	 */
	public function index(Request $request)
	{

		// get menu category
		$this->data->menutag = $this->getMenuTag($this->language, $this->entity, $request);

		// get params
		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);

		// get objects
		$this->data->objects = $this->getFrontObjects($request, $this->language, $this->entity, $this->activeroute, $this->data->menutag, $this->data->params);

		// get terms
		$this->data->terms = $this->getEntityTerms($this->language, $this->entity, null);

		// filter by taxonomy
		$this->data = $this->setTaxonomyFilter($this->data, $this->data);

		// get related module page
		$this->data->modulepage = $this->getModulePageBySlug($this->language, $this->entity, 'index');

		// use menu tag or module page for Intro
		$this->data->page = $this->data->menutag ?: $this->data->modulepage;

		// seo
		$this->data->seo = $this->getSeo($this->data->modulepage);

		// opengraph
		$this->data->opengraph = $this->getOpengraph($this->data->modulepage);

		// get language versions
		$this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity);

		// override default layout with custom module page layout
		$this->data->layout = $this->getObjectThemeLayout($this->data->modulepage, $this->data->params);
		$this->data->grid = $this->getGrid($this->data->layout);

		// template vars & override
		$this->data->gridvars = $this->getGridVars($this->entity);
		$this->data->override = $this->getGridOverride($this->entity, $this->activeroute);

		$viewfile = $this->getFrontViewFile($this->entity, $this->activeroute);

		return view($viewfile, [
			'data' => $this->data,
		]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param Request $request
	 * @param string|null $slug
	 * @return Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|View|object
	 */
	public function show(Request $request, string $slug = null)
	{

		// get menutaxonomy (for previous and next model)
		$this->data->menutag = $this->getSingleMenuTag($this->language, $this->entity, $request);

		// get params
		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);

		// get active term
		$this->data->tag = $this->getTagBySlug($this->language, $this->entity, $this->data->params->getFilterByTaxonomy());

		// get single object
		$this->data->object = $this->getSingleFrontObject($this->language, $this->entity, $slug);

		// check redirect
		$this->checkFrontRedirect($this->language, $this->entity, $this->activeroute, $this->data->object);

		// related objects from other entities
		$this->data->relatedObjects = $this->getFrontRelated($this->entity, $this->data->object->id);

		// get related module page (from parent index method) for Layout and SEO
		$this->data->modulepage = $this->getModulePageBySlug($this->language, $this->entity, 'index');

		// Use object for Hero if it has a hero image
		$this->data->page = $this->getHeroPage($this->data->object, $this->data->menutag, $this->data->modulepage);

		// get terms
		$this->data->terms = $this->getEntityTerms($this->language, $this->entity, null);

		// seo
		$this->data->seo = $this->getSeo($this->data->object, $this->data->modulepage);

		// opengraph
		$this->data->opengraph = $this->getOpengraph($this->data->object);

		// get language versions
		$this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity, $this->data->object);

		// override default layout with custom module page layout
		$this->data->layout = $this->getObjectThemeLayout($this->data->modulepage);
		$this->data->grid = $this->getGrid($this->data->layout);

		// template vars & override
		$this->data->gridvars = $this->getGridVars($this->entity);
		$this->data->override = $this->getGridOverride($this->entity, $this->activeroute);

		// get previous and next object
		if($this->data->params->getPrevNext()) {
			$this->data->next = $this->getNextObject($this->language, $this->entity, $this->activeroute, $this->data->object, $this->data->params, $this->data->menutag);
			$this->data->prev = $this->getPrevObject($this->language, $this->entity, $this->activeroute, $this->data->object, $this->data->params, $this->data->menutag);
		}

		// get entity list url
		$this->data->entityListUrl = $this->getEntityListUrl($this->language, $this->entity, $this->activeroute, $this->data->object, $this->data->menutag);

		// get view file
		$viewfile = $this->getFrontViewFile($this->entity, $this->activeroute);

		return view($viewfile, [
			'data' => $this->data,
		]);

	}

	/**
	 * @return string
	 * @throws ReflectionException
	 */
	protected function determineModelClass(): string
	{
		return (new ReflectionClass($this))
			->getMethod('make')
			->getReturnType()
			->getName();
	}

}
