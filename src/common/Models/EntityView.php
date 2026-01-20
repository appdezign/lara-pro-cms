<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityView extends Model
{

    protected $table = 'lara_resource_entity_views';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

	/**
	 * @param Builder $query
	 * @return Builder
	 */
	public function scopeIsSingle(Builder $query)
	{
		return $query->where('is_single', 1);
	}

	/**
	 * @return BelongsTo
	 */
	public function entity()
	{
		return $this->belongsTo(\Lara\Common\Models\Entity::class);
	}

}
