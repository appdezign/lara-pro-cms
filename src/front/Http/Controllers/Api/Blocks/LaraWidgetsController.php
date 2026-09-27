<?php

namespace Lara\Front\Http\Controllers\Api\Blocks;

use Lara\Common\Models\LaraWidget;
use Lara\Front\Http\Controllers\Api\Base\BaseApiController;

class LaraWidgetsController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function make(): LaraWidget
    {
        return LaraWidget::create();
    }
}
