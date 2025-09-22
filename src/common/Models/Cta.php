<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cta extends BaseModel
{
    protected $table = 'lara_blocks_ctas';

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
