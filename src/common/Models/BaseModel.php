<?php

namespace Lara\Common\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lara\Admin\Enums\CustomFieldType;
use Lara\Common\Entities\EntityRegistry;
use Lara\Common\Models\Concerns\HasLaraLocks;
use Lara\Common\Models\Concerns\HasLaraMedia;
use Usamamuneerchaudhary\FilaRank\Concerns\HasSeo;

class BaseModel extends Model implements HasRichContent
{
	use HasFactory;
	use HasLaraLocks;
	use HasLaraMedia;
	use HasSeo;
	use InteractsWithRichContent;
	use Sluggable;
	use SoftDeletes;

	/**
	 * Per model class and entity config version, see getCustomFieldCasts().
	 *
	 * @var array<string, array<string, string>>
	 */
	private static array $customFieldCasts = [];

	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected function casts(): array
	{
		return [
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
			'deleted_at' => 'datetime',
			'publish_from' => 'datetime',
			'publish_to' => 'datetime',
			'bricks' => 'array',
			...static::getCustomFieldCasts(),
		];
	}

	/**
	 * Array casts for the custom fields stored in json columns (multiselect, checkbox list, …).
	 *
	 * Derived from the entity configuration, so a field added in the admin works without editing
	 * the model. Casts a model declares itself still take precedence.
	 *
	 * @return array<string, string>
	 */
	protected static function getCustomFieldCasts(): array
	{
		$registry = app(EntityRegistry::class);
		$cacheKey = static::class.'|'.$registry->version();

		if (array_key_exists($cacheKey, self::$customFieldCasts)) {
			return self::$customFieldCasts[$cacheKey];
		}

		$casts = [];

		foreach ($registry->findByModelClass(static::class)?->customFields() ?? [] as $customField) {
			$fieldType = CustomFieldType::tryFrom((string) $customField->field_type);

			if ($fieldType?->getDatabaseColumnType() == 'json') {
				$casts[$customField->field_name] = 'array';
			}
		}

		return self::$customFieldCasts[$cacheKey] = $casts;
	}

	// get Seo content for FilaRank
	public function getSeoContent(): ?string
	{
		return $this->body;
	}

	// get Seo slug for FilaRank
	public function getSeoSlug(): ?string
	{
		return $this->slug;
	}

	public function setUpRichContent(): void
	{

		// standard fields
		$this->registerRichContent('lead');
		$this->registerRichContent('body')
			->customBlocks($this->getCustomBlocks());

		// extra body fields
		for ($i = 2; $i <= config('lara.filament.max_extra_body_fields') + 1; $i++) {
			$this->registerRichContent('body'.$i)
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
				'source' => 'title',
			],
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
		return $this->morphToMany(Tag::class, 'entity', config('lara-common.database.object.taggables'))->whereHas('taxonomy', fn ($query) => $query->where('slug', 'tag'))->orderBy('position');
	}

	public function categories(): MorphToMany
	{
		return $this->morphToMany(Tag::class, 'entity', config('lara-common.database.object.taggables'))->whereHas('taxonomy', fn ($query) => $query->where('slug', 'category'))->orderBy('position');
	}

	/**
	 * Published, and the publication moment has passed.
	 *
	 * Compares full timestamps rather than dates: whereDate() truncated
	 * publish_from to a date, so anything published today was excluded until
	 * the following day. A null publish_from means "published immediately".
	 */
	public function scopeIsPublished(Builder $query): Builder
	{
		return $query->where('publish', 1)
			->where(function ($query) {
				$query->where('publish_from', '<=', Carbon::now())
					->orWhereNull('publish_from');
			});
	}

	/**
	 * Not past its expiry moment. A null publish_to means "never expires".
	 */
	public function scopeIsNotExpired(Builder $query): Builder
	{
		return $query->where(function ($query) {
			$query->where('publish_to', '>', Carbon::now())
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
