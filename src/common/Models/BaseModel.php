<?php

namespace Lara\Common\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;

use Cviebrock\EloquentSluggable\Sluggable;

use Lara\Common\Models\Concerns\HasLaraMedia;
use Lara\Common\Models\Concerns\HasLaraLocks;

class BaseModel extends Model implements HasRichContent
{
	use Sluggable;
	use SoftDeletes;
	use InteractsWithRichContent;

	use HasLaraMedia;
	use HasLaraLocks;

	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected function casts(): array
	{
		return [
			'created_at'   => 'datetime',
			'updated_at'   => 'datetime',
			'deleted_at'   => 'datetime',
			'publish_from' => 'datetime',
			'publish_to'   => 'datetime',
			'bricks'       => 'array',
		];
	}

	public function setUpRichContent(): void
	{

		// standard fields
		$this->registerRichContent('lead');
		$this->registerRichContent('body')
			->customBlocks($this->getCustomBlocks());

		// extra body fields
		for ($i = 2; $i <= config('lara.filament.max_extra_body_fields') + 1; $i++) {
			$this->registerRichContent('body' . $i)
				->customBlocks($this->getCustomBlocks());
		}

	}

	public function getCustomBlocks(): array
	{
		return config('lara-admin.rich_editor.custom_blocks') ?? [];
	}

	public static function getTableName()
	{
		return with(new static)->getTable();
	}

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

	public function terms(): MorphToMany
	{
		return $this->morphToMany(Tag::class, 'entity', config('lara-common.database.object.taggables'))->orderBy('position');
	}

	public function tags(): MorphToMany
	{
		return $this->morphToMany(Tag::class, 'entity', config('lara-common.database.object.taggables'))->whereHas('taxonomy', fn($query) => $query->where('slug', 'tag'))->orderBy('position');
	}

	public function categories(): MorphToMany
	{
		return $this->morphToMany(Tag::class, 'entity', config('lara-common.database.object.taggables'))->whereHas('taxonomy', fn($query) => $query->where('slug', 'category'))->orderBy('position');
	}

	public function scopeIsPublished(Builder $query): Builder
	{
		return $query->where('publish', 1)
			->whereDate('publish_from', '<', Carbon::now()->toDateTimeString());
	}

	public function scopeIsNotExpired(Builder $query): Builder
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

	public function sync(): MorphOne
	{
		return $this->morphOne(Sync::class, 'entity');
	}

	public function seo(): MorphOne
	{
		return $this->morphOne(ObjectSeo::class, 'entity');
	}

	public function opengraph(): MorphOne
	{
		return $this->morphOne(ObjectOpenGraph::class, 'entity');
	}

	public function ogimage(): BelongsTo
	{
		return $this->opengraph()->firstOrCreate()->ogImg();
	}

	public function hasOpenGraphImage(): bool
	{
		return !empty($this->ogimage);

	}

	public function files(): MorphOne
	{
		return $this->morphOne(ObjectFile::class, 'entity');
	}

	public function videofiles(): MorphOne
	{
		return $this->morphOne(ObjectVideofile::class, 'entity');
	}

	public function videos(): MorphOne
	{
		return $this->morphOne(ObjectVideo::class, 'entity');
	}

	public function layout(): MorphOne
	{
		return $this->morphOne(ObjectLayout::class, 'entity');
	}

	public function related(): MorphOne
	{
		return $this->morphOne(ObjectRelated::class, 'entity');
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class)->withTrashed();
	}

}
