<?php

namespace Lara\Front\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Lara\Common\Models\Entity;
use Lara\Common\Models\Page;
use Lara\Front\Http\Concerns\HasError;
use Lara\Front\Http\Concerns\HasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;
use Lara\Front\Http\Concerns\HasFrontList;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontObject;
use Lara\Front\Http\Concerns\HasFrontView;
use LaravelLocalization;
use stdClass;

class ErrorController extends Controller
{
    use HasError;
    use HasFrontend;
    use HasFrontEntity;
    use HasFrontList;
    use HasFrontMenu;
    use HasFrontObject;
    use HasFrontView;

    protected ?string $routename = null;

    protected ?object $entity = null;

    protected ?object $activeroute = null;

    protected ?string $language = null;

    protected ?object $data = null;

    protected ?object $globalwidgets = null;

    protected ?object $globalsettings = null;

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

            // get global settings
            $this->globalsettings = $this->getGlobalSettings();

            // share data with all views, see: https://goo.gl/Aqxquw
            $this->middleware(function ($request, $next) {
                view()->share('entity', $this->entity);
                view()->share('activeroute', $this->activeroute);
                view()->share('language', $this->language);
                view()->share('ispreview', $this->ispreview);
                view()->share('globalwidgets', $this->globalwidgets);
                view()->share('globalsettings', $this->globalsettings);
                view()->share('activemenu', $this->getActiveMenuArray());
                view()->share('firstpageload', $this->getFirstPageLoad());

                return $next($request);
            });
        }

    }

    /**
     * @return Application|Factory|View
     */
    public function show(Request $request)
    {

        // get Error ID
        $errorId = $this->getErrorIdFromRoutename($this->routename);

        // get params
        $this->data->params = $this->getFrontParams($this->entity, $this->activeroute, $request);
        if ($this->data->params instanceof RedirectResponse) {
            return $this->data->params;
        }

        // get Error Page
        $this->data->object = $this->findOrCreateErrorPage($errorId, $this->language);

        // get language versions
        $this->data->langversions = $this->getFrontLanguageVersions($this->language, $this->entity, $this->data->object);

        $this->data->grid = $this->getGrid($this->data->layout);

        // template vars & override
        $this->data->gridvars = $this->getGridVars($this->entity);
        $this->data->override = $this->getGridOverride($this->entity, $this->activeroute);

        $viewfile = '_error.'.$errorId;

        return view($viewfile, [
            'data' => $this->data,
        ]);

    }
}
