<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectSeo extends Model
{

    protected $table = 'lara_object_seo';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

}
