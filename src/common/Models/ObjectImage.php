<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObjectImage extends Model
{

    protected $table = 'lara_object_images';

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

	public function media(): BelongsTo
	{
		return $this->belongsTo(Media::class, 'media_id', 'id');
	}


}
