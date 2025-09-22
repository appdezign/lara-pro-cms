<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectVideofile extends Model
{

    protected $table = 'lara_object_videofiles';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

	protected $casts = [
		'entity_videofiles' => 'array',
	];

}
