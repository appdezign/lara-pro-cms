<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectImage extends Model
{

    protected $table = 'lara_object_images';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

	protected $casts = [
		'featured' => 'array',
		'thumb' => 'array',
		'hero' => 'array',
		'icon' => 'array',
		'gallery_upload' => 'array',
		'gallery' => 'array',
	];


}
