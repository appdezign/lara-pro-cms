<?php

namespace Lara\Front\Http\Controllers\Api\Page;

use Lara\Common\Models\Page;
use Lara\Front\Http\Controllers\Api\Base\BaseApiController;

class PagesController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function make(): Page
    {
        return Page::create();
    }
}
