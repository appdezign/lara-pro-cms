<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

use Lara\Common\Models\Page;

class LaraWidget extends BaseModel
{
    protected $table = 'lara_blocks_widgets';

	/**
	 * @return MorphToMany
	 */
	public function onpages()
	{
		return $this->morphToMany(Page::class, 'entity', config('lara-common.database.object.pageables'));
	}
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

}
