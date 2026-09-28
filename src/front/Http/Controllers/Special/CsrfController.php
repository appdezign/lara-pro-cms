<?php

namespace Lara\Front\Http\Controllers\Special;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CsrfController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @return View
     */
    public function show(Request $request, string $type)
    {

        $csrftoken = csrf_token();

        return view('_partials.csrf.show', [
            'type' => $type,
            'csrftoken' => $csrftoken,
        ]);

    }
}
