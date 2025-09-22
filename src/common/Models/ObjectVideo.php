<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectVideo extends Model
{

    protected $table = 'lara_object_videos';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

	protected $casts = [
		'entity_videos' => 'array',
	];

}
