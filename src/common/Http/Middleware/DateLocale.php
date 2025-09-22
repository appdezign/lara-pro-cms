<?php

namespace Lara\Common\Http\Middleware;

use Closure;

use LaravelLocalization;

// use Jenssegers\Date\Date;

use Carbon\Carbon;

class DateLocale {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		$language = LaravelLocalization::getCurrentLocale();

		Carbon::setLocale($language);

		return $next($request);
	}

}
