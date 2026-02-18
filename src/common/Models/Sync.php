<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

class Sync extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'lara_object_sync';

	/**
	 * @var array
	 */
	/**
	 * @var array
	 */
	protected $guarded = [
		'id',
	];

	/**
	 * @return MorphTo
	 */
	public function entity()
	{
		return $this->morphTo();
	}

}
