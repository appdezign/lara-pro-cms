<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectFile extends Model
{

    protected $table = 'lara_object_files';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

	protected $casts = [
		'entity_files' => 'array',
	];

}
