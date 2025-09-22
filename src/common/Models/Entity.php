<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{

	protected $table = 'lara_resource_entities';

	/**
	 * @var array
	 */
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'objrel_group_values' => 'array',
	];

	/*
	* @return HasMany
	*/
	public function customfields()
	{
		return $this->hasMany('Lara\Common\Models\EntityCustomField');
	}

	/*
	* @return HasMany
	*/
	public function relations(): HasMany
	{
		return $this->hasMany('Lara\Common\Models\EntityRelation');
	}

	/*
	* @return HasMany
	*/
	public function views(): HasMany
	{
		return $this->hasMany('Lara\Common\Models\EntityView');
	}
}
