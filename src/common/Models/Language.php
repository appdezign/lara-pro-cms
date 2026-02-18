<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'lara_sys_languages';

	/**
	 * @var string[]
	 */
	protected $guarded = [
		'id',
	];

	protected $casts = [
		'created_at'   => 'datetime',
		'updated_at'   => 'datetime',
	];

	/**
	 * @param Builder $query
	 * @return Builder
	 */
	public function scopeIsDefault(Builder $query)
	{
		return $query->where('default', 1);
	}

	/**
	 * @param Builder $query
	 * @return Builder
	 */
	public function scopeIsPublished(Builder $query)
	{
		return $query->where('publish', 1);
	}

}
