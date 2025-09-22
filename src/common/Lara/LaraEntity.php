<?php

namespace Lara\Common\Lara;

use Lara\Common\Models\Entity;
use Cache;

class LaraEntity
{

	protected ?object $entity = null;
	public ?string $resource_slug = null;
	protected ?string $module; // eve, admin
	protected ?string $prefix = null;
	protected ?string $method = null;

	public function __construct()
	{
		$this->entity = $this->getEntity($this->resource_slug);
	}

	public function getEntity(string $resource_slug)
	{
		$cachekey = 'entity_config_' . $resource_slug;
		return Cache::rememberForever($cachekey, function () use ($resource_slug) {
			$entity = Entity::where('resource_slug', $resource_slug)->first();
			if (empty($entity)) {
				$entity = Entity::where('resource_slug', 'base')->first();
			}
			return $entity;
		});
	}

	public function getModule(): ?string
	{
		return $this->module;
	}

	public function getResourceSlug(): ?string
	{
		return $this->entity->resource_slug;
	}

	public function getEntityId(): int
	{
		return $this->entity->id;
	}

	public function getEntityTitle(): ?string
	{
		return $this->entity->title;
	}

	public function getLabelSingle(): ?string
	{
		return $this->entity->label_single;
	}

	public function getResource(): ?string
	{
		return $this->entity->resource;
	}

	public function getPolicy(): ?string
	{
		return $this->entity->policy;
	}

	public function getEntityModelClass(): ?string
	{
		return $this->entity->model_class;
	}

	public function getEntityController(): ?string
	{
		return $this->entity->controller;
	}

	public function getNavGroup(): ?string
	{
		return $this->entity->nav_group;
	}

	public function getNavPosition(): ?int
	{
		return $this->entity->position;
	}

	public function getCgroup(): ?string
	{
		return $this->entity->cgroup;
	}

	public function hasLead(): bool
	{
		return boolval($this->entity->col_has_lead);
	}

	public function hasBody(): bool
	{
		return boolval($this->entity->col_has_body);
	}

	public function getMaxBodyFields(): ?int
	{
		return $this->entity->col_extra_body_fields;
	}

	public function hasStatus(): bool
	{
		return boolval($this->entity->col_has_status);
	}

	public function hasExpiration(): bool
	{
		return boolval($this->entity->col_has_expiration);
	}

	public function hasHideinlist(): bool
	{
		return boolval($this->entity->col_has_hideinlist);
	}

	public function isSortable(): bool
	{
		return boolval($this->entity->sort_is_sortable);
	}

	public function getPrimarySortField(): string
	{
		return $this->entity->sort_primary_field ?? 'id';
	}

	public function getPrimarySortOrder(): string
	{
		return $this->entity->sort_primary_order ?? 'asc';
	}

	public function getSecondarySortField(): ?string
	{
		return $this->entity->sort_secondary_field;
	}

	public function getSecondarySortOrder(): ?string
	{
		return $this->entity->sort_secondary_order;
	}

	public function showSearch(): bool
	{
		return boolval($this->entity->show_search);
	}

	public function showBatch(): bool
	{
		return boolval($this->entity->show_batch);
	}

	public function showStatus(): bool
	{
		return boolval($this->entity->show_status);
	}

	public function showSeo(): bool
	{
		return boolval($this->entity->show_seo);
	}

	public function showOpengraph(): bool
	{
		return boolval($this->entity->show_opengraph);
	}

	public function showAuthor(): bool
	{
		return boolval($this->entity->show_author);
	}

	public function showSync(): bool
	{
		return boolval($this->entity->show_sync);
	}

	public function showRichLead(): bool
	{
		return boolval($this->entity->show_rich_lead);
	}

	public function showRichBody(): bool
	{
		return boolval($this->entity->show_rich_body);
	}

	public function hasTerms(): bool
	{
		return boolval($this->entity->objrel_has_terms);
	}

	// legacy
	public function hasTags(): bool
	{
		return boolval($this->entity->objrel_has_terms);
	}

	public function hasGroups(): bool
	{
		return boolval($this->entity->objrel_has_groups);
	}

	public function getGroups(): array
	{
		return $this->entity->objrel_group_values;
	}

	public function hasRelated(): bool
	{
		return boolval($this->entity->objrel_has_related);
	}

	public function isRelatable(): bool
	{
		return boolval($this->entity->objrel_is_relatable);
	}

	public function hasFeaured(): bool
	{
		return boolval($this->entity->media_has_featured);
	}

	public function hasThumb(): bool
	{
		return boolval($this->entity->media_has_thumb);
	}

	public function hasHero(): bool
	{
		return boolval($this->entity->media_has_hero);
	}

	public function hasIcon(): bool
	{
		return boolval($this->entity->media_has_icon);
	}

	public function hasGallery(): bool
	{
		return boolval($this->entity->media_has_gallery);
	}

	public function hasGalleryPro(): bool
	{
		return boolval($this->entity->media_has_gallery_pro);
	}

	public function hasVideos(): bool
	{
		return boolval($this->entity->media_has_videos);
	}

	public function hasVideoFiles(): bool
	{
		return boolval($this->entity->media_has_videofiles);
	}

	public function hasFiles(): bool
	{
		return boolval($this->entity->media_has_files);
	}

	public function hasImages(): bool
	{
		return $this->hasFeaured() || $this->hasThumb() || $this->hasHero() || $this->hasIcon();
	}

	public function getMaxGallery(): ?int
	{
		return intval($this->entity->media_max_gallery);
	}

	public function getMaxVideos(): ?int
	{
		return intval($this->entity->media_max_videos);
	}

	public function getMaxVideoFiles(): ?int
	{
		return intval($this->entity->media_max_videofiles);
	}

	public function getMaxFiles(): ?int
	{
		return intval($this->entity->media_max_files);
	}

	public function getCustomColumns(): object
	{
		return $this->entity->customfields;
	}

	public function getViews()
	{
		return $this->entity->views;
	}

	public function getRelations()
	{
		return $this->entity->relations;
	}

}
