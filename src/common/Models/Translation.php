<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{


    protected $table = 'lara_sys_translations';

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
		'deleted_at' => 'datetime',
	];

	/**
     * Language scope.
     *
     * @param Builder $query
     * @param string $language
     * @return Builder
     */
    public function scopeLangIs(Builder $query, string $language): Builder
    {
        return $query->where('language', $language);
    }
}
