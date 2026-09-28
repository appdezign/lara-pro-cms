<?php

namespace Lara\Common\Http\Middleware;

use App;
use Auth;
use Closure;
use Config;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;
use Lara\Common\Models\Language;

class UserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (! empty(Auth::user()->user_language)) {
            $language = Auth::user()->user_language;
        } else {
            $default = Language::where('publish', 1)->where('backend', 1)->where('backend_default', 1)->first();
            if ($default) {
                $language = $default->code;
            } else {
                // fall back
                $language = Config::get('app.locale');
            }
        }

        App::setLocale($language);

        Date::setLocale($language);

        return $next($request);
    }
}
