<?php

namespace Lara\Common\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
	use Sluggable;

	protected $table = 'lara_menu_menus';

    protected $fillable = [
        'name',
        'slug',
    ];

	protected $casts = [
		'created_at'   => 'datetime',
		'updated_at'   => 'datetime',
	];

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable(): array
	{
		return [
			'slug' => [
				'source' => 'name'
			]
		];
	}

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

}
