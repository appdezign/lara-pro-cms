<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slider extends BaseModel
{
    protected $table = 'lara_blocks_sliders';

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
