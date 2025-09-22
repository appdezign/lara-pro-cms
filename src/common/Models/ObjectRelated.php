<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectRelated extends Model
{

    protected $table = 'lara_object_related';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

	protected $casts = [
		'related_page_objects' => 'array',
		'related_entity_objects' => 'array',
		'related_entities' => 'array',
	];

}
