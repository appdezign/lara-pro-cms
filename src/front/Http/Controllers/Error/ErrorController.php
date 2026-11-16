<?php

namespace Lara\Front\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
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
        $this->data = new stdClass;
    }

    /**
     * The error route (error.show.{code}), which is also the front catch-all for unknown URLs.
     */
    public function show(Request $request): Response|RedirectResponse
    {
        $this->prepare(Route::current()->getName());

        return $this->renderErrorPage($this->getErrorIdFromRoutename($this->routename), $request);
    }

    /**
     * Render the 404 page on the requested URL, for a 404 raised anywhere in the front
     * (a missing object, an abort(404)). Called by the exception renderer that
     * LaraFrontServiceProvider registers.
     */
    public function renderNotFound(Request $request): Response|RedirectResponse
    {
        $this->prepare('error.show.404');

        return $this->renderErrorPage('404', $request);
    }

    /**
     * Set up the page data and share it with the views.
     *
     * This runs in the action, not in the constructor: the constructor has no
     * session yet, and the exception renderer needs the setup for the error
     * route, not for the route that was matched.
     */
    private function prepare(string $routename): void
    {
        $this->language = LaravelLocalization::getCurrentLocale();

        $this->routename = $routename;

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

        view()->share('entity', $this->entity);
        view()->share('activeroute', $this->activeroute);
        view()->share('language', $this->language);
        view()->share('ispreview', $this->ispreview);
        view()->share('globalwidgets', $this->globalwidgets);
        view()->share('globalsettings', $this->globalsettings);
        view()->share('activemenu', $this->getActiveMenuArray());
        view()->share('firstpageload', $this->getFirstPageLoad());
    }

    protected function renderErrorPage(string $errorId, Request $request): Response|RedirectResponse
    {

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

        return response()->view($viewfile, [
            'data' => $this->data,
        ], $this->getErrorStatus($errorId));

    }

    /**
     * The HTTP status for an error page: its code when that is an error status, otherwise 404.
     */
    private function getErrorStatus(string $errorId): int
    {
        $status = (int) $errorId;

        return ($status >= 400 && $status < 600) ? $status : 404;
    }
}
