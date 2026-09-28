<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lara\Common\Entities\EntityConfigObserver;

#[ObservedBy(EntityConfigObserver::class)]
class Entity extends Model
{
    protected $table = 'lara_resource_entities';

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

    public function customfields(): HasMany
    {
        return $this->hasMany(EntityCustomField::class);
    }

    public function relations(): HasMany
    {
        return $this->hasMany(EntityRelation::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(EntityView::class);
    }
}
