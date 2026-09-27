<?php

namespace Lara\Common\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use LaravelLocalization;

class DateLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $language = LaravelLocalization::getCurrentLocale();

        Carbon::setLocale($language);

        return $next($request);
    }
}
