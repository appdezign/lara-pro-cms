<?php

namespace Lara\Front\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Lara\Common\Models\User;
use Lara\Front\Http\Concerns\HasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontList;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontObject;
use Lara\Front\Http\Concerns\HasFrontView;
use Lara\Front\Http\Concerns\HasTheme;
use LaravelLocalization;
use stdClass;

class BaseProfileController extends Controller
{
	use HasFrontend;
	use HasFrontEntity;
	use HasFrontList;
	use HasFrontMenu;
	use HasFrontObject;
	use HasFrontView;
	use HasTheme;

	protected ?string $modelClass = User::class;

	protected ?string $routename = null;

	protected ?object $entity = null;

	protected ?object $activeroute = null;

	protected ?string $language = null;

	protected ?object $data = null;

	protected ?object $globalwidgets = null;

	protected ?object $globalsettings = null;

	public function __construct()
	{

		// get language
		$this->language = LaravelLocalization::getCurrentLocale();

		// create an empty Laravel object to hold all the data (see: https://goo.gl/ufmFHe)
		$this->data = new stdClass;

		// only when handling a matched HTTP request: there is no route to read
		// in console, queue or test-bootstrap contexts
		if (Route::current() !== null) {

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

			$this->globalsettings = $this->getGlobalSettings();

			// share data with all views, see: https://goo.gl/Aqxquw
			$this->middleware(function ($request, $next) {
				view()->share('entity', $this->entity);
				view()->share('activeroute', $this->activeroute);
				view()->share('language', $this->language);
				view()->share('ispreview', $this->ispreview);
				view()->share('globalwidgets', $this->globalwidgets);
				view()->share('globalsettings', $this->globalsettings);

				return $next($request);
			});
		}

	}

	public function form(Request $request)
	{

		if (! config('lara.auth.has_front_profile')) {
			return redirect()->route('special.home.show');
		}

		$this->data->object = $this->modelClass::find(Auth::user()->id);

		// get params
		$this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);
		if ($this->data->params instanceof RedirectResponse) {
			return $this->data->params;
		}

		// get related module page for SEO and Intro
		$this->data->modulepage = $this->getModulePageBySlug($this->language, $this->entity, 'form');

		// Use module page for Intro
		$this->data->page = $this->data->modulepage;

		// seo
		$this->data->seo = $this->getSeo($this->data->modulepage);

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

		if (! config('lara.auth.has_front_profile')) {
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
