<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityRelation extends Model
{

    protected $table = 'lara_resource_entity_relations';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

	public function scopeIsFilter(Builder $query)
	{
		return $query->where('is_filter', 1);
	}

	/**
	 * @return BelongsTo
	 */
	public function entity()
	{
		return $this->belongsTo(\Lara\Common\Models\Entity::class, 'entity_id');
	}

	/**
	 * @return BelongsTo
	 */
	public function relatedEntity(): BelongsTo
	{
		return $this->belongsTo(\Lara\Common\Models\Entity::class, 'related_entity_id');
	}

}
