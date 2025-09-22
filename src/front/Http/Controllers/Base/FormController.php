<?php

namespace Lara\Front\Http\Controllers\Base;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

use Lara\Front\Mail\MailConfirmation;
use Lara\Front\Rules\ReCaptcha;

use LaravelLocalization;

use ReflectionClass;
use ReflectionException;

use stdClass;

class FormController extends Controller
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
	 * Show the form
	 *
	 * @param Request $request
	 * @return Application|Factory|View
	 */
	public function form(Request $request)
	{

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
		$this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity);

		// override default layout with custom module page layout
		$this->data->layout = $this->getObjectThemeLayout($this->data->modulepage);
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
	 * Process form
	 *
	 * @param Request $request
	 * @return false|string
	 * @throws BindingResolutionException
	 */
	public function process(Request $request)
	{

		$validationRules = $this->getValidationRules($this->entity);
		if (config('app.env') == 'production' && config('lara.google_recaptcha_site_key')) {
			$validationRules['g-recaptcha-response'] = [new ReCaptcha];
		}
		$request->validate($validationRules);

		// save data
		$formfields = array();
		$formfields[] = 'title';
		foreach ($this->entity->getCustomColumns() as $field) {
			// fix empty strings
			if ($field->required == 0) {
				if ($field->fieldtype == 'text' || $field->fieldtype == 'string') {
					$fieldname = $field->fieldname;
					if (empty($request->input($fieldname))) {
						$request->merge([$fieldname => '']);
					}
				}
			}
			// add field to array
			$formfields[] = $field->fieldname;
		}
		if ($request->has('name')) {
			$request->merge(['title' => $request->input('name')]);
		}

		// patch 6.2.23 - start
		if ($request->has('_ipaddress')) {
			$this->checkBlackListColumn($this->entity);
			$formfields[] = 'ipaddress';
			$request->merge(['ipaddress' => $request->input('_ipaddress')]);
		}
		// patch 6.2.23 - end

		$newObject = $this->modelClass::create($request->only($formfields));

		$isSpam = $this->detectSpam($this->entity, $newObject, ['text']);

		if ($isSpam->result) {
			// Soft delete because it is suspicious (spam)
			$newObject->delete();
			$result = array(
				"message"    => $isSpam->message,
				"sendstatus" => 1,
			);
		} else {
			// SEND MAIL
			$this->sendMail($request);
			$result = array(
				"message"    => _q('lara-front::default.form.mail_sent_successfully'),
				"sendstatus" => 1,
			);
		}

		return json_encode($result);

	}

	/**
	 * @param Request $request
	 * @return void
	 * @throws BindingResolutionException
	 */
	private function sendMail(Request $request)
	{

		$maildata = new stdClass;

		// company
		$company = $this->getSettingsByGroup('company');
		$maildata->company = $company;

		// visitor
		if($request->has('email')) {
			$user = $app->make('stdClass');
			$user->email = $request->input('email');
			if ($request->has('name')) {
				$user->name = $request->input('name');
			}
		} else {
			$user = null;
		}

		// webmaster
		$webmaster = $app->make('stdClass');
		if (config('app.env') == 'production') {
			$webmaster->email = $company->company_email;
			$webmaster->name = $company->company_name;
		} else {
			$webmaster->email = config('lara.admin_company_email');
			$webmaster->name = config('lara.admin_company_name');
		}

		// from
		$maildata->from = $app->make('stdClass');
		$maildata->from->email = $company->company_email;
		$maildata->from->name = $company->company_name;

		// subject
		$maildata->subject = _q('lara-eve::' . $this->entity->getResourceSlug() . '.email.subject');

		// style
		$maildata->style = json_decode(json_encode(config('lara-front.mail')), false);

		// Content
		$intro = $this->getEmailPageContent($this->language, $this->entity->getResourceSlug());
		$maildata->content = $app->make('stdClass');
		$maildata->content->title = $intro->title;
		$maildata->content->lead = $intro->lead;
		$maildata->content->body = strip_tags($intro->body);

		// dynamic content
		$maildata->content->data = $app->make('stdClass');
		foreach ($this->entity->getCustomColumns() as $field) {
			$fieldname = $field->fieldname;
			if($field->fieldtype == 'boolean' || $field->fieldtype == 'yesno') {
				if($request->input($fieldname) == 1) {
					$fieldvalue = _q('lara-admin::default.value.yes');
				} else {
					$fieldvalue = _q('lara-admin::default.value.no');
				}
			} else {
				$fieldvalue = $request->input($fieldname);
			}
			$maildata->content->data->$fieldname = [
				'colname' => _q('lara-eve::' . $this->entity->getResourceSlug() . '.column.' . $fieldname),
				'colval'  => $fieldvalue,
			];
		}

		// mail to visitor
		if($user) {
			$maildata->view = 'email.' . $this->entity->getResourceSlug() . '.confirm';
			Mail::to($user)->queue(new MailConfirmation($maildata));
		}

		// mail to webmaster
		$maildata->view = 'email.' . $this->entity->getResourceSlug() . '.webmaster';
		$mlr = (config('app.env') == 'production') ? 'smtp' : 'dev';
		Mail::mailer($mlr)->to($webmaster)->queue(new MailConfirmation($maildata));


	}

	/**
	 * @return RedirectResponse
	 */
	public function redirect()
	{

		// redirect GET requests

		return redirect()->route('special.home.show');

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
