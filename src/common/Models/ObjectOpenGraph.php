<?php

namespace Lara\Common\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

	public function ogImg(): BelongsTo
	{
		return $this->belongsTo(Media::class, 'og_image', 'id');
	}

}
