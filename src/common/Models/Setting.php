<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lara\Common\Models\Concerns\HasLaraLocks;

class Setting extends Model
{

    use SoftDeletes;
	use HasLaraLocks;

    protected $table = 'lara_sys_settings';

    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

	protected $casts = [
		'created_at'   => 'datetime',
		'updated_at'   => 'datetime',
		'deleted_at'   => 'datetime',
	];

	public static function getTableName()
	{
		return with(new static)->getTable();
	}

}
