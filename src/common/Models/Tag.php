<?php

namespace Lara\Common\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;
use Lara\Common\Models\Concerns\HasLaraLocks;
use Lara\Common\Models\Concerns\HasLaraMedia;

class Tag extends Model
{
    use HasLaraLocks;
    use HasLaraMedia;
    use NodeTrait, Sluggable {
        NodeTrait::replicate insteadof Sluggable;
        Sluggable::replicate as replct;
    }

    /**
     * @var string
     */
    protected $table = 'lara_object_tags';

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

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * kalnoy/nestedset - scope
     *
     * @return string[]
     */
    protected function getScopeAttributes()
    {
        return ['language', 'resource_slug', 'taxonomy_id'];
    }

    /**
     * kalnoy/nestedset - column override (_lft)
     *
     * @return string
     */
    public function getLftName()
    {
        return 'lft';
    }

    /**
     * kalnoy/nestedset - column override (_rgt)
     *
     * @return string
     */
    public function getRgtName()
    {
        return 'rgt';
    }

    /**
     * @return BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    }

    /**
     * @return Builder
     */
    public function scopeResourceIs(Builder $query, string $resource_slug)
    {
        return $query->where('resource_slug', $resource_slug);
    }

    /**
     * @return Builder
     */
    public function scopeTaxonomyIs(Builder $query, int $taxonomyId)
    {
        return $query->where('taxonomy_id', $taxonomyId);
    }

    /**
     * Language scope.
     *
     * @return Builder
     */
    public function scopeLangIs(Builder $query, string $language)
    {
        return $query->where('language', $language);
    }
}
