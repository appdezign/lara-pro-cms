<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectLayout extends Model
{

    protected $table = 'lara_object_layout';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

	protected $casts = [
		'entity_layout' => 'array',
	];

}
