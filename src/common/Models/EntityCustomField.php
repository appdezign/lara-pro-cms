<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\Sluggable;

class EntityCustomField extends Model
{
	use Sluggable;

    protected $table = 'lara_resource_entity_custom_fields';

	public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

	protected $casts = [
		'field_options' => 'array',
	];

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable(): array
	{
		return [
			'field_name' => [
				'source' => 'title',
				'separator' => '_'
			]
		];
	}

	public function scopeIsFilter(Builder $query)
	{
		return $query->where('is_filter', 1);
	}

	/**
	 * @return BelongsTo
	 */
	public function entity()
	{
		return $this->belongsTo(\Lara\Common\Models\Entity::class);
	}

}
