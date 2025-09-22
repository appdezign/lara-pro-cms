<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectOpenGraph extends Model
{

    protected $table = 'lara_object_opengraph';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

}
