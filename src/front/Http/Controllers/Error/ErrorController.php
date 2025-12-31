<?php

namespace Lara\Front\Http\Controllers\Error;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Lara\Common\Models\Page;
use Lara\Common\Models\Entity;
use Lara\Common\Models\User;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontList;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontObject;
use Lara\Front\Http\Concerns\HasFrontView;
use Lara\Front\Http\Concerns\HasError;

use LaravelLocalization;

use stdClass;

class ErrorController extends Controller
{

	use hasFrontend;
	use HasFrontEntity;
	use HasFrontList;
	use HasFrontMenu;
	use HasFrontObject;
	use HasFrontView;
	use HasError;

	protected ?string $routename;
	protected ?object $entity;
	protected ?object $activeroute;
	protected ?string $language;
	protected ?object $data;
	protected ?object $globalwidgets;
	protected bool $ismobile;
	protected bool $ispreview;

	public function __construct()
	{

		// get language
		$this->language = LaravelLocalization::getCurrentLocale();

		$this->data = new stdClass;

		if (!App::runningInConsole()) {

			// get route name
			$this->routename = Route::current()->getName();

			$this->ispreview = $this->isPreview($this->routename);

			// get Page entity
			$this->entity = $this->getResourceBySlug('pages');

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
				view()->share('ispreview', $this->ispreview);
				view()->share('globalwidgets', $this->globalwidgets);
				view()->share('activemenu', $this->getActiveMenuArray());
				view()->share('firstpageload', $this->getFirstPageLoad());

				return $next($request);
			});
		}

	}

	/**
	 * @param Request $request
	 * @return Application|Factory|View
	 */
	public function show(Request $request)
	{

		// get Error ID
		$errorId = $this->getErrorIdFromRoutename($this->routename);

		// get params
		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);

		// get Error Page
		$this->data->object = $this->findOrCreateErrorPage($errorId, $this->language);

		// get language versions
		$this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity, $this->data->object);

		$this->data->grid = $this->getGrid($this->data->layout);

		// template vars & override
		$this->data->gridvars = $this->getGridVars($this->entity);
		$this->data->override = $this->getGridOverride($this->entity, $this->activeroute);

		$viewfile = '_error.' . $errorId;

		return view($viewfile, [
			'data' => $this->data,
		]);

	}

}
