<?php

namespace Lara\Common\Models;

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

use Cviebrock\EloquentSluggable\Sluggable;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;

use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;

use Lara\Admin\Components\CustomBlocks\HeroBlock;

use Cache;

class BaseModel extends Model implements HasRichContent
{
	use Sluggable;
	use SoftDeletes;
	use HasLocks;
	use InteractsWithRichContent;

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

	/**
	 * @return MorphOne
	 */
	public function images(): MorphOne
	{
		return $this->morphOne('Lara\Common\Models\ObjectImage', 'entity');
	}

	/**
	 * @return MorphOne
	 */
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

	public function getFeatured()
	{
		return $this->getMediaRepeaterData($this->images, 'featured', 'featured', true);
	}

	public function hasFeatured(): bool
	{
		return isset($this->images) && !empty($this->images->featured);
	}

	public function getThumb()
	{
		return $this->getMediaRepeaterData($this->images, 'thumb', 'thumb', true);
	}

	public function hasThumb(): bool
	{
		return isset($this->images) && !empty($this->images->thumb);
	}

	public function hasThumbOrFeatured(): bool
	{
		return isset($this->images) && (!empty($this->images->thumb || !empty($this->images->featured)));
	}

	public function getThumbOrFeatured()
	{
		if ($this->hasThumb()) {
			return $this->getMediaRepeaterData($this->images, 'thumb', 'thumb', true);
		} elseif ($this->hasFeatured()) {
			return $this->getMediaRepeaterData($this->images, 'featured', 'featured', true);
		} else {
			return null;
		}
	}

	public function getHero()
	{
		return $this->getMediaRepeaterData($this->images, 'hero', 'hero', true);
	}

	public function hasHero(): bool
	{
		return isset($this->images) && !empty($this->images->hero);
	}

	public function getIcon()
	{
		return $this->getMediaRepeaterData($this->images, 'icon', 'icon', true);
	}

	public function hasIcon(): bool
	{
		return isset($this->images) && !empty($this->images->icon);
	}

	public function getGallery(): ?array
	{
		return $this->getMediaRepeaterData($this->images, 'gallery', 'gallery');
	}

	public function hasGallery(): bool
	{
		return isset($this->images) && !empty($this->images->gallery);
	}

	public function hasImages(): bool
	{
		return $this->hasFeatured()
			|| $this->hasThumb()
			|| $this->hasHero()
			|| $this->hasIcon()
			|| $this->hasGallery();
	}

	public function getFile(): ?\stdClass
	{
		// get single file
		return $this->getMediaRepeaterData($this->files, 'entity_files', 'doc', true);
	}

	public function getFiles(): ?array
	{
		// get array of files
		return $this->getMediaRepeaterData($this->files, 'entity_files', 'doc');
	}

	public function hasFiles(): bool
	{
		return isset($this->files) && !empty($this->files->entity_files);
	}

	public function getVideoFile(): ?\stdClass
	{
		// get single video file
		return $this->getMediaRepeaterData($this->videofiles, 'entity_videofiles', 'videofile', true);
	}

	public function getVideoFiles(): ?array
	{
		// get array of video files
		return $this->getMediaRepeaterData($this->videofiles, 'entity_videofiles', 'videofile');
	}

	public function hasVideoFiles(): bool
	{
		return isset($this->videofiles) && !empty($this->videofiles->entity_videofiles);
	}

	public function getVideo(): ?\stdClass
	{
		// get single video
		return $this->getMediaRepeaterData($this->videos, 'entity_videos', 'video', true);
	}

	public function getVideos()
	{
		// get array of videos
		return $this->getMediaRepeaterData($this->videos, 'entity_videos', 'video');
	}

	public function hasVideos(): bool
	{
		return isset($this->videos) && !empty($this->videos->entity_videos);
	}

	public function hasImageCount(): ?int
	{
		return $this->images->image_count ?? null;
	}

	private function getMediaRepeaterData($data, string $column, ?string $prefix = null, bool $single = false)
	{

		if ($data && $data->$column) {
			$array = array();
			foreach ($data->$column as $item) {
				$object = new \stdClass();
				foreach ($item as $key => $value) {
					if ($prefix) {
						$newKey = Str::replaceStart($prefix . '_', '', $key);
						$object->$newKey = $value;
					} else {
						$object->$key = $value;
					}
				}
				if (property_exists($object, 'filename')) {
					$filename = $object->filename;
					$parts = explode('/', $filename);
					if (sizeof($parts) == 2) {
						$object->filedir = $parts[0];
						$object->filename = $parts[1];
					} else {
						$object->filedir = null;
						$object->filename = $filename;
					}
				}
				$array[] = $object;
			}
			if ($single) {
				return $array[0];
			} else {
				return $array;
			}
		} else {
			return null;
		}
	}

}
