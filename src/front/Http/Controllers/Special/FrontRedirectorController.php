<?php

namespace Lara\Front\Http\Controllers\Special;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lara\Front\Http\Concerns\HasFrontRedirect;

class FrontRedirectorController extends Controller
{
    use HasFrontRedirect;

    /**
     * @var string|null
     */
    protected $routename;

    public function __construct()
    {
        // only when handling a matched HTTP request: there is no route to read
        // in console, queue or test-bootstrap contexts
        if (Route::current() !== null) {
            $this->routename = Route::current()->getName();
        }
    }

    /**
     * @return void
     */
    public function process(Request $request)
    {
        $redirect = $this->processRedirect($request, $this->routename);
        if ($redirect instanceof RedirectResponse) {
            return $redirect;
        }
    }

    /**
     * @return void
     */
    public function redirectHome()
    {
        $redirect = $this->getRedirectHome();
        if ($redirect instanceof RedirectResponse) {
            return $redirect;
        }
    }

    /**
     * @return RedirectResponse
     */
    public function redirectSetup()
    {
        $redirect = $this->getRedirectSetup();
        if ($redirect instanceof RedirectResponse) {
            return $redirect;
        }
    }
}
