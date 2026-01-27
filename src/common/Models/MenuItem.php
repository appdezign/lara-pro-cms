<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Lara\Admin\Enums\MenuItemType;

use Kalnoy\Nestedset\NodeTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Lara\Common\Models\Concerns\HasLaraLocks;

class MenuItem extends Model
{
	use Sluggable, NodeTrait {
		NodeTrait::replicate insteadof Sluggable;
		Sluggable::replicate as replct;
	}

	use HasLaraLocks;

	protected $table = 'lara_menu_menu_items';

	/**
	 * @var array
	 */
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	protected $casts = [
		'type' => MenuItemType::class,
		'created_at'   => 'datetime',
		'updated_at'   => 'datetime',
	];

    public $timestamps = false;

    protected $touches = ['menu'];

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable(): array
	{
		return [
			'slug' => [
				'source' => 'title'
			]
		];
	}

	public static function getTableName()
	{
		return with(new static)->getTable();
	}

	// Nested set scope
	// TODO: add language
	protected function getScopeAttributes(): array
	{
		return ['language', 'menu_id'];
	}

	public function scopeLangIs(Builder $query, string $language)
	{
		return $query->where('language', $language);
	}

	public function scopeIsHome(Builder $query)
	{
		return $query->where('is_home', 1);
	}

	public function scopeMenuIs(Builder $query, int $menu_id)
	{
		return $query->where('menu_id', $menu_id);
	}

	public function scopeMenuSlugIs(Builder $query, string $slug)
	{
		return $query->whereHas('menu', function ($query) use ($slug) {
			$query->where(config('lara-common.database.menu.menus') . '.slug', $slug);
		});
	}

	public function scopeTypeIs(Builder $query, string $type)
	{
		return $query->where('type', $type);
	}

	public function scopeIsPublished(Builder $query)
	{
		return $query->where('publish', 1);
	}


	public function menu(): BelongsTo
	{
		return $this->belongsTo(Menu::class);
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
	public function entity()
	{
		return $this->belongsTo(\Lara\Common\Models\Entity::class, 'entity_id');
	}

	/**
	 * @return BelongsTo
	 */
	public function entityview()
	{
		return $this->belongsTo(\Lara\Common\Models\EntityView::class, 'entity_view_id');
	}

}
