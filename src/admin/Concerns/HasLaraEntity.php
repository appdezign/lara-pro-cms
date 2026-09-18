<?php

namespace Lara\Admin\Concerns;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Lara\Admin\Enums\NavGroup;
use Lara\Common\Entities\EntityConfig;
use Lara\Common\Entities\EntityRegistry;
use Lara\Common\Models\Entity;

trait HasLaraEntity
{

	/**
	 * The configuration row for this resource.
	 *
	 * Served by EntityRegistry, which holds every entity behind a single cache
	 * key. This used to keep its own `lara_entity_{slug}` rememberForever entry,
	 * separate from the one in LaraEntity, and neither was ever invalidated.
	 *
	 * @throws ModelNotFoundException when the resource has no entity row
	 */
	public static function getEntity(): Entity
	{
		$resourceSlug = static::getSlug();

		$entity = app(EntityRegistry::class)->model($resourceSlug);

		if (!$entity) {
			throw (new ModelNotFoundException())
				->setModel(Entity::class, [$resourceSlug]);
		}

		return $entity;
	}

	/**
	 * Typed configuration for this resource. Prefer this in new code.
	 */
	public static function getEntityConfig(): EntityConfig
	{
		return app(EntityRegistry::class)->get(static::getSlug());
	}

	public static function getEntityNavGroup(): ?string
	{
		$navGroup = static::getEntity()->nav_group;

		if(empty($navGroup) || $navGroup == 'root') {
			return '';
		} else {
			$navigationGroup = NavGroup::from($navGroup);
			$locale = App::currentLocale();
			if($locale == 'nl') {
				return $navigationGroup->getLabelNl();
			} else {
				return $navigationGroup->getLabelEn();
			}
		}
	}

    // columns
    public static function resourceHasLead(): bool
    {
        return static::getEntity()->col_has_lead;
    }

    public static function resourceHasBody(): bool
    {
        return static::getEntity()->col_has_body;
    }

    public static function maxBodyFields(): int
    {
        return static::getEntity()->col_extra_body_fields;
    }

    public static function resourceHasStatus(): bool
    {
        return static::getEntity()->col_has_status;
    }

    public static function resourceHasExpiration(): bool
    {
        return static::getEntity()->col_has_expiration;
    }

    public static function resourceHasHideInList(): bool
    {
        return static::getEntity()->col_has_hideinlist;
    }

    // sort order
    public static function resourceIsSortable(): bool
    {
        return static::getEntity()->sort_is_sortable;
    }

    public static function getPrimarySortField(): string
    {
        $primarySortField = static::getEntity()->sort_primary_field;
        return !empty($primarySortField) ? $primarySortField : 'id';
    }

    public static function getPrimarySortOrder(): string
    {
        $primarySortOrder = static::getEntity()->sort_primary_order;
        return !empty($primarySortOrder) ? $primarySortOrder : 'asc';
    }

    public static function getSecondarySortField(): ?string
    {
        $secondarySortField = static::getEntity()->sort_secondary_field;
        return $secondarySortField ?? null;
    }

    public static function getSecondarySortOrder(): ?string
    {
        $secondarySortOrder = static::getEntity()->sort_secondary_order;
        return $secondarySortOrder ?? null;
    }

    // Sections
    public static function resourceShowSearch(): bool
    {
        return static::getEntity()->show_search;
    }

    public static function resourceShowBatch(): bool
    {
        return static::getEntity()->show_batch;
    }

    public static function resourceShowStatus(): bool
    {
        return static::getEntity()->show_status;
    }

    public static function resourceShowSeo(): bool
    {
        return static::getEntity()->show_seo;
    }

	public static function resourceShowSync(): bool
	{
		return static::getEntity()->show_sync;
	}

    public static function resourceShowAuthor(): bool
    {
        return static::getEntity()->show_author;
    }

    public static function leadHasRichEditor(): bool
    {
        return static::getEntity()->show_rich_lead;
    }

    public static function bodyHasRichEditor(): bool
    {
        return static::getEntity()->show_rich_body;
    }

    public static function showViewAction(): bool
    {
        return static::getEntity()->show_view_action;
    }

    public static function showEditAction(): bool
    {
        return static::getEntity()->show_edit_action;
    }

    public static function showDeleteAction(): bool
    {
        return static::getEntity()->show_delete_action;
    }

    public static function showRestoreAction(): bool
    {
        return static::getEntity()->show_restore_action;
    }

	// relations
	public static function resourceHasTerms(): bool
	{
		return static::getEntity()->objrel_has_terms;
	}

	public static function resourceHasGroups(): bool
	{
		return static::getEntity()->objrel_has_groups;
	}

	public static function resourceHasRelated(): bool
	{
		return static::getEntity()->objrel_has_related;
	}

	// Media

	public static function resourceHasMainImages(): bool
	{
		return (
			static::resourceHasFeatured()
			|| static::resourceHasThumb()
			|| static::resourceHasHero()
			|| static::resourceHasIcon()
		);
	}

	public static function resourceHasMedia(): bool
	{
		return (
			static::resourceHasFeatured()
			|| static::resourceHasThumb()
			|| static::resourceHasHero()
			|| static::resourceHasIcon()
			|| static::resourceHasGallery()
		);
	}

	public static function resourceHasFeatured(): bool
	{
		return static::getEntity()->media_has_featured;
	}

	public static function resourceHasThumb(): bool
	{
		return static::getEntity()->media_has_thumb;
	}

	public static function resourceHasHero(): bool
	{
		return static::getEntity()->media_has_hero;
	}

	public static function resourceHasIcon(): bool
	{
		return static::getEntity()->media_has_icon;
	}

	public static function resourceHasGallery(): bool
	{
		return static::getEntity()->media_has_gallery;
	}

	public static function resourceHasFiles(): bool
	{
		return static::getEntity()->media_has_files;
	}

	public static function resourceHasVideos(): bool
	{
		return static::getEntity()->media_has_videos;
	}

	public static function resourceHasVideoFiles(): bool
	{
		return static::getEntity()->media_has_videofiles;
	}

	public static function getMaxGallery(): int
	{
		return static::getEntity()->media_max_gallery;
	}

	public static function getMaxVideos(): int
	{
		return static::getEntity()->media_max_videos;
	}

	public static function getMaxVideofiles(): int
	{
		return static::getEntity()->media_max_videofiles;
	}

	public static function getMaxFiles(): int
	{
		return static::getEntity()->media_max_files;
	}

	public static function getDiskForImages(): string
	{
		return static::getEntity()->media_disk_images;
	}

	public static function getDiskForFiles(): string
	{
		return static::getEntity()->media_disk_files;
	}

	public static function getDiskForVideos(): string
	{
		return static::getEntity()->media_disk_videos;
	}

}
