<?php

namespace Lara\Front\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Lara\Front\Http\Concerns\HasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontList;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontObject;
use Lara\Front\Http\Concerns\HasFrontRoutes;
use Lara\Front\Http\Concerns\HasFrontView;
use LaravelLocalization;
use stdClass;

class BasePagesController extends Controller
{
	use HasFrontend;
	use HasFrontEntity;
	use HasFrontList;
	use HasFrontMenu;
	use HasFrontObject;
	use HasFrontRoutes;
	use HasFrontView;

	protected ?string $routename = null;

	protected ?object $entity = null;

	protected ?object $activeroute = null;

	protected ?string $language = null;

	protected ?object $data = null;

	protected ?object $globalwidgets = null;

	protected bool $ispreview = false;

	public function __construct()
	{

		// get language
		$this->language = LaravelLocalization::getCurrentLocale();

		$this->data = new stdClass;

		// only when handling a matched HTTP request: there is no route to read
		// in console, queue or test-bootstrap contexts
		if (Route::current() !== null) {

			// get route name
			$this->routename = Route::current()->getName();

			// preview
			$this->ispreview = $this->isPreview($this->routename);

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

			// share data with all views, see: https://goo.gl/Aqxquw
			$this->middleware(function ($request, $next) {
				view()->share('entity', $this->entity);
				view()->share('activeroute', $this->activeroute);
				view()->share('language', $this->language);
				view()->share('ispreview', $this->ispreview);
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
	 * @return Application|Factory|View
	 */
	public function show(Request $request, int|string|null $id = null)
	{

		// get params
		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);
		if ($this->data->params instanceof RedirectResponse) {
			return $this->data->params;
		}

		// get page ID from request or route
		$pageId = $this->getPageObjectId($id, $this->activeroute);

		// get single object
		$this->data->object = $this->getSingleFrontObject($this->language, $this->entity, $pageId);
		if ($this->data->object instanceof RedirectResponse) {
			return $this->data->params;
		}

		// redirect pages to their menu url, if possible
		$checkPage = $this->checkPageRoute($this->language, $this->entity, $this->activeroute, $this->data->object->id);
		if ($checkPage instanceof \Illuminate\Http\RedirectResponse) {
			return $checkPage;
		}

		// get page children
		$this->data->children = $this->getPageChildren($this->language);

		// Use Page object for Intro (Hero)
		$this->data->page = $this->data->object;

		// seo
		$this->data->seo = $this->getSeo($this->data->object);

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

		$viewfile = $this->getFrontViewFile($this->entity, $this->activeroute);

		return view($viewfile, [
			'data' => $this->data,
		]);

	}
}
