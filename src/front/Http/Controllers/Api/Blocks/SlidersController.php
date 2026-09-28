<?php

namespace Lara\Front\Http\Controllers\Api\Blocks;

use Lara\Common\Models\Slider;
use Lara\Front\Http\Controllers\Api\Base\BaseApiController;

class SlidersController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function make(): Slider
    {
        return Slider::create();
    }
}
