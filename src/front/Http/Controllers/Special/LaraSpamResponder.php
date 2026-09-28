<?php

namespace Lara\Front\Http\Controllers\Special;

use Closure;
use Illuminate\Http\Request;
use Spatie\Honeypot\SpamResponder\SpamResponder;

class LaraSpamResponder implements SpamResponder
{
    public function respond(Request $request, Closure $next)
    {
        return response('spam detected');
    }
}
