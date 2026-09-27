<?php

namespace Lara\Common\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// use Rutorika\Sortable\SortableTrait;

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
     * @return Builder
     */
    public function scopeIsDefault(Builder $query)
    {
        return $query->where('is_default', 1);
    }
}
