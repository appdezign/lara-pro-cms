<?php

namespace Lara\Common\Models;

use Awcodes\Curator\Glide\GlideBuilder;
use Awcodes\Curator\Models\Media;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;

use Cviebrock\EloquentSluggable\Sluggable;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;

use Lara\Common\Models\Concerns\HasLaraMedia;

use Cache;

class BaseModel extends Model implements HasRichContent
{
	use Sluggable;
	use SoftDeletes;
	use HasLocks;
	use InteractsWithRichContent;

	use HasLaraMedia;

	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $casts = [
		'created_at'   => 'datetime',
		'updated_at'   => 'datetime',
		'deleted_at'   => 'datetime',
		'publish_from' => 'datetime',
		'publish_to'   => 'datetime',
	];

	public function setUpRichContent(): void
	{

		// standard fields
		$this->registerRichContent('lead');
		$this->registerRichContent('body')
			->customBlocks($this->getCustomBLocks());

		// extra body fields
		for ($i = 2; $i <= config('lara.filament.max_extra_body_fields') + 1; $i++) {
			$this->registerRichContent('body' . $i)
				->customBlocks($this->getCustomBLocks());
		}

	}

	public function getCustomBLocks(): array
	{
		return config('lara-admin.rich_editor.custom_blocks') ?? [];
	}

	/**
	 * Get table name.
	 *
	 * @return mixed
	 */
	public static function getTableName()
	{
		return with(new static)->getTable();
	}

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

	public static function getFilamentSearchLabel(): string
	{
		return 'title';
	}

	/**
	 * @return MorphToMany
	 */
	public function terms(): MorphToMany
	{
		return $this->morphToMany('Lara\Common\Models\Tag', 'entity', config('lara-common.database.object.taggables'))->orderBy('position');
	}

	/**
	 * @return MorphToMany
	 */
	public function tags(): MorphToMany
	{
		return $this->morphToMany('Lara\Common\Models\Tag', 'entity', config('lara-common.database.object.taggables'))->whereHas('taxonomy', fn($query) => $query->where('slug', 'tag'))->orderBy('position');
	}

	/**
	 * @return MorphToMany
	 */
	public function categories(): MorphToMany
	{
		return $this->morphToMany('Lara\Common\Models\Tag', 'entity', config('lara-common.database.object.taggables'))->whereHas('taxonomy', fn($query) => $query->where('slug', 'category'))->orderBy('position');
	}

	public function scopeIsPublished(Builder $query)
	{
		return $query->where('publish', 1)
			->whereDate('publish_from', '<', Carbon::now()->toDateTimeString());
	}

	public function scopeIsNotExpired(Builder $query)
	{
		return $query->where(function ($query) {
			$query->whereDate('publish_to', '>', Carbon::now()->toDateTimeString())
				->orWhereNull('publish_to');
		});
	}

	public function scopeLangIs(Builder $query, string $language): Builder
	{
		return $query->where('language', $language);
	}

	/**
	 * @return MorphOne
	 */
	public function sync()
	{
		return $this->morphOne('Lara\Common\Models\Sync', 'entity');
	}

	/**
	 * @return MorphOne
	 */
	public function seo(): MorphOne
	{
		return $this->morphOne('Lara\Common\Models\ObjectSeo', 'entity');
	}

	/**
	 * @return MorphOne
	 */
	public function opengraph(): MorphOne
	{
		return $this->morphOne('Lara\Common\Models\ObjectOpenGraph', 'entity');
	}

	public function ogimage()
	{
		return $this->opengraph()->firstOrCreate()->ogImg();
	}

	public function hasOpenGraphImage() {
		return !empty($this->ogimage);

	}

	public function files(): MorphOne
	{
		return $this->morphOne('Lara\Common\Models\ObjectFile', 'entity');
	}

	/**
	 * @return MorphOne
	 */
	public function videofiles(): MorphOne
	{
		return $this->morphOne('Lara\Common\Models\ObjectVideofile', 'entity');
	}

	/**
	 * @return MorphOne
	 */
	public function videos(): MorphOne
	{
		return $this->morphOne('Lara\Common\Models\ObjectVideo', 'entity');
	}

	/**
	 * @return MorphOne
	 */
	public function layout(): MorphOne
	{
		return $this->morphOne('Lara\Common\Models\ObjectLayout', 'entity');
	}

	/**
	 * @return MorphOne
	 */
	public function related()
	{
		return $this->morphOne('Lara\Common\Models\ObjectRelated', 'entity');
	}

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo('Lara\Common\Models\User')->withTrashed();
	}

}
