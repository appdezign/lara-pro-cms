<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{

    use SoftDeletes;

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


}
