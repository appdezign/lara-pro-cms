<?php

namespace Lara\Front\Http\Controllers\Special;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Lara\Front\Http\Concerns\HasFrontRedirect;

class FrontRedirectorController extends Controller
{

	use hasFrontRedirect;

	/**
	 * @var string|null
	 */
	protected $routename;

	public function __construct()
	{
		if (!App::runningInConsole()) {
			$this->routename = Route::current()->getName();
		}
	}

	/**
	 * @param Request $request
	 * @return void
	 */
	public function process(Request $request)
	{
		$this->processRedirect($request, $this->routename);
	}

	/**
	 * @return void
	 */
	public function redirectHome()
	{
		return $this->processRedirectHome();
	}

	/**
	 * @return RedirectResponse
	 */
	public function redirectSetup()
	{
		$this->processRedirectSetup();
	}

}
