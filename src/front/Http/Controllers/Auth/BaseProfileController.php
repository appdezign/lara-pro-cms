<?php

namespace Lara\Front\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Lara\Common\Models\User;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontList;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontObject;
use Lara\Front\Http\Concerns\hasTheme;
use Lara\Front\Http\Concerns\HasFrontView;

use Jenssegers\Agent\Agent;

use LaravelLocalization;

use stdClass;

class BaseProfileController extends Controller
{

	use hasFrontend;
	use HasFrontEntity;
	use HasFrontList;
	use HasFrontMenu;
	use HasFrontObject;
	use hasTheme;
	use HasFrontView;

	protected ?string $modelClass = User::class;
	protected ?string $routename;
	protected ?object $entity;
	protected ?object $activeroute;
	protected ?string $language;
	protected ?object $data;
	protected ?object $globalwidgets;
	protected bool $ismobile;

	public function __construct()
	{

		// get language
		$this->language = LaravelLocalization::getCurrentLocale();

		// create an empty Laravel object to hold all the data (see: https://goo.gl/ufmFHe)
		$this->data = new stdClass;

		if (!App::runningInConsole()) {

			// get route name
			$this->routename = Route::current()->getName();

			// preview
			$this->ispreview = $this->isPreview($this->routename);

			// get active route
			$this->activeroute = $this->getLaraActiveRoute($this->routename);

			// get entity
			$this->entity = $this->getFrontEntity($this->routename);

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

				return $next($request);
			});
		}

	}

	public function form(Request $request)
	{

		if(!config('lara.auth.has_front_profile')) {
			return redirect()->route('special.home.show');
		}

		$this->data->object = $this->modelClass::find(Auth::user()->id);

		// get params
		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);

		// get related module page for SEO and Intro
		$this->data->modulepage = $this->getModulePageBySlug($this->language, $this->entity, 'form');

		// Use module page for Intro
		$this->data->page = $this->data->modulepage;

		// seo
		$this->data->seo = $this->getSeo($this->data->modulepage);

		// opengraph
		$this->data->opengraph = $this->getOpengraph($this->data->modulepage);

		// get language versions
		$this->data->langversions = [];

		// override default layout with custom module page layout
		$this->data->layout = $this->getObjectThemeLayout($this->data->modulepage);
		$this->data->grid = $this->getGrid($this->data->layout);

		// template vars & override
		$this->data->gridvars = $this->getGridVars($this->entity);
		$this->data->override = $this->getGridOverride($this->entity, $this->activeroute);

		$viewfile = '_user.profile.form';

		return view($viewfile, [
			'data' => $this->data,
		]);

	}

	public function process(Request $request)
	{

		if(!config('lara.auth.has_front_profile')) {
			return redirect()->route('special.home.show');
		}

		$id = Auth::user()->id;

		$object = $this->modelClass::findOrFail($id);

		if ($request->input('_password') != '') {
			$object->password = $request->input('_password');
		}

		// save object
		$object->update($request->all());

		flash(_q('lara-front::user.message.profile_saved_successfully'))->success();

		return redirect()->route('special.user.profile');

	}


}

