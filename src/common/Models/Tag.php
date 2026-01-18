<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Kalnoy\Nestedset\NodeTrait;

use Lara\Common\Models\Concerns\HasLaraMedia;

class Tag extends Model
{

	use Sluggable, NodeTrait {
		NodeTrait::replicate insteadof Sluggable;
		Sluggable::replicate as replct;
	}

	use HasLaraMedia;

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

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}

	/**
	 * @return array
	 */
	public function sluggable(): array
	{
		return [
			'slug' => [
				'source' => 'title',
			],
		];
	}

	/**
	 * get Table Columns
	 *
	 * @return array
	 */
	public function getTableColumns()
	{
		return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
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
		return $this->belongsTo(\Lara\Common\Models\Taxonomy::class, 'taxonomy_id');
	}


	/**
	 * @param Builder $query
	 * @param string $resource_slug
	 * @return Builder
	 */
	public function scopeResourceIs(Builder $query, string $resource_slug)
	{
		return $query->where('resource_slug', $resource_slug);
	}

	/**
	 * @param Builder $query
	 * @param int $taxonomyId
	 * @return Builder
	 */
	public function scopeTaxonomyIs(Builder $query, int $taxonomyId)
	{
		return $query->where('taxonomy_id', $taxonomyId);
	}

	/**
	 * Language scope.
	 *
	 * @param Builder $query
	 * @param string $language
	 * @return Builder
	 */
	public function scopeLangIs(Builder $query, string $language)
	{
		return $query->where('language', $language);
	}

}
