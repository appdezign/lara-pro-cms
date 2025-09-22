<?php

namespace Lara\Front\Http\Controllers\Page;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontList;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontObject;
use Lara\Front\Http\Concerns\HasFrontRoutes;
use Lara\Front\Http\Concerns\HasFrontView;

use Jenssegers\Agent\Agent;

use LaravelLocalization;

use stdClass;

class BaseHomeController extends Controller
{

	use hasFrontend;
	use HasFrontEntity;
	use HasFrontList;
	use HasFrontMenu;
	use HasFrontObject;
	use HasFrontRoutes;
	use HasFrontView;

	protected ?string $routename;
	protected ?object $entity;
	protected ?object $activeroute;
	protected ?string $language;
	protected ?object $data;
	protected ?object $globalwidgets;
	protected ?bool $ismobile;

	public function __construct()
	{

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
	 * Display the page.
	 *
	 * @param Request $request
	 * @return Application|Factory|View
	 */
	public function show(Request $request)
	{

		// get params
		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);

		// get object
		$this->data->object = $this->getHomePage($this->language);

		// Use Page object for Intro (Hero)
		$this->data->page = $this->data->object;

		// seo
		$this->data->seo = $this->getSeo($this->data->object);

		// opengraph
		$this->data->opengraph = $this->getOpengraph($this->data->object);

		// get language versions
		$this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity, $this->data->object);

		// override default layout with custom page layout
		$this->data->layout = $this->getObjectThemeLayout($this->data->object);

		$this->data->grid = $this->getGrid($this->data->layout);

		// template vars & override
		$this->data->gridvars = $this->getGridVars($this->entity);
		$this->data->override = $this->getGridOverride($this->entity, $this->activeroute);

		// related objects (from other entities)
		$this->data->relatedObjects = $this->getFrontRelated($this->entity, $this->data->object->id);

		$viewfile = 'content.home.show';

		return view($viewfile, [
			'data' => $this->data,
		]);

	}

}
