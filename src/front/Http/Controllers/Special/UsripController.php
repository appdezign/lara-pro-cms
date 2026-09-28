<?php

namespace Lara\Front\Http\Controllers\Special;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsripController extends Controller
{
    public function __construct(Request $request)
    {
        //
    }

    /**
     * @return View
     */
    public function show(Request $request, $type)
    {

        return view('_partials.usrip.show', [
            'type' => $type,
        ]);

    }
}
