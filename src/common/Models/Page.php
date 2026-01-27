<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Page extends BaseModel
{

    protected $table = 'lara_content_pages';

	/**
	 * @return BelongsTo
	 */
	public function languageParent(): BelongsTo
	{
		return $this->belongsTo(self::class, 'language_parent');
	}

	/**
	 * @return HasMany
	 */
	public function languageChildren(): HasMany
	{
		return $this->hasMany(self::class, 'language_parent');
	}

	/**
	 * @return MorphToMany
	 */
	public function widgets()
	{
		return $this->morphedByMany(LaraWidget::class, 'entity', config('lara-common.database.object.pageables'))
			->where('is_global', 0)
			->orderBy('hook', 'asc')
			->orderBy('sortorder', 'asc');
	}

}
