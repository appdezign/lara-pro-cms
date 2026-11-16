<?php

namespace Lara\Front\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Lara\Common\Http\Controllers\Setup\Concerns\HasSetup;
use Lara\Front\Http\Concerns\HasFrontend;
use Lara\Front\Http\Concerns\HasTheme;
use Lara\Front\Http\Controllers\Error\ErrorController;
use Lara\Front\LaraTheme\ContentViewFinder;
use Lara\Front\LaraTheme\Theme;
use Lara\Front\LaraTheme\ThemeViewFinder;
use Lara\Front\View\Components\FrontFormRowComponent;
use Lara\Front\View\Components\FrontShowRowComponent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Usamamuneerchaudhary\FilaRank\Http\Middleware\HandleRedirects;

class LaraFrontServiceProvider extends ServiceProvider
{
    /**
     * The site's error controller (generated into laracms/app); core's own is the fallback.
     */
    private const APP_ERROR_CONTROLLER = 'Lara\\App\\Http\\Controllers\\Front\\Error\\AppErrorController';

    use HasFrontend;
    use HasSetup;
    use HasTheme;

    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {

        // Publish Config
        $this->publishes([
            __DIR__.'/../../../config/lara-front.php' => config_path('lara-front.php'),
        ], 'lara');

        // Publish Views
        $this->loadViewsFrom(__DIR__.'/../../../resources/views/front', 'lara-front');

        // Load Translations
        $this->loadTranslationsFrom(app()->langPath().'/vendor/lara-front', 'lara-front');

        // register components
        Blade::component('frontformrow', FrontFormRowComponent::class);
        Blade::component('frontshowrow', FrontShowRowComponent::class);

        $this->registerRedirectMiddleware();

        $this->registerNotFoundRenderer();

        // Frontend only.
        //
        // runningInConsole() is true under PHPUnit as well as under artisan,
        // because both run on the CLI SAPI. Tests that simulate a frontend
        // request do need the theme and the shared settings, so they are
        // distinguished with runningUnitTests().
        $isServingRequest = ! App::runningInConsole() || App::runningUnitTests();

        if ($isServingRequest && ! $this->app->request->is('admin/*')) {

            // Set theme
            $theme = $this->getFrontTheme();
            $parent = $this->getParentTheme();

            Theme::set($theme, $parent);

        }

    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {

        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../../../config/lara-front.php', 'lara-front');

        $this->app->register(LaraFrontRouteProvider::class);

        $this->registerViewFinder();

        $this->registerThemeFinder();

        // register facade alias, so we can use it in templates
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Theme', '\Lara\Front\LaraTheme\Facade\LaraTheme');
        });

    }

    /**
     * Apply the redirects in seo_redirects (managed in the admin under SEO).
     *
     * filarank's middleware serves a matching redirect before the request
     * reaches the controller, and logs front 404s. The front catch-all route
     * (error.show.404) is in the web group, so unknown URLs pass through it too.
     */
    protected function registerRedirectMiddleware(): void
    {
        $this->app['router']->pushMiddlewareToGroup('web', HandleRedirects::class);
    }

    /**
     * Render front 404s as the CMS error page (layout, menu, widgets) on the requested URL.
     *
     * Admin, API, Livewire and JSON requests keep Laravel's own 404. If the error
     * page itself fails, Laravel's plain 404 is the fallback.
     */
    protected function registerNotFoundRenderer(): void
    {
        $handler = $this->app->make(ExceptionHandler::class);

        if (! $handler instanceof Handler) {
            return;
        }

        $handler->renderable(function (NotFoundHttpException $e, Request $request): ?Response {

            if (! $this->isFrontPageRequest($request)) {
                return null;
            }

            try {
                $controllerClass = class_exists(self::APP_ERROR_CONTROLLER) ? self::APP_ERROR_CONTROLLER : ErrorController::class;

                return $this->app->make($controllerClass)->renderNotFound($request);
            } catch (Throwable $renderException) {
                Log::error('lara error page: could not render the 404 page', [
                    'url' => $request->fullUrl(),
                    'exception' => $renderException,
                ]);

                return null;
            }
        });
    }

    private function isFrontPageRequest(Request $request): bool
    {
        if ($request->expectsJson()) {
            return false;
        }

        return ! $request->is('admin', 'admin/*', 'livewire/*', 'livewire-*/*', 'api/*', '*/api/*');
    }

    /**
     * The view finder falls back to the base content templates (see ContentViewFinder).
     */
    protected function registerViewFinder(): void
    {
        $this->app->bind('view.finder', function ($app) {
            return new ContentViewFinder($app['files'], $app['config']['view.paths']);
        });
    }

    protected function registerThemeFinder(): void
    {
        $this->app->singleton('theme.finder', function ($app) {
            $themeFinder = new ThemeViewFinder(
                $app['files'],
                $app['config']['view.paths']
            );

            $themeFinder->setHints(
                $this->app->make('view')->getFinder()->getHints()
            );

            return $themeFinder;
        });

    }
}
