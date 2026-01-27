<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Cviebrock\EloquentSluggable\Sluggable;

// use Rutorika\Sortable\SortableTrait;

use Carbon\Carbon;

class Taxonomy extends Model
{

	use Sluggable;

	// use SortableTrait;

	/**
	 * @var string
	 */
	protected $table = 'lara_object_taxonomies';

	/**
	 * @var string[]
	 */
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];

	/**
	 * @return array
	 */
	public function sluggable(): array
	{
		return [
			'slug' => [
				'source' => 'title',
			],
		];
	}

	/**
	 * Language scope.
	 *
	 * @param Builder $query
	 * @return Builder
	 */
	public function scopeIsDefault(Builder $query)
	{
		return $query->where('is_default', 1);
	}

}
