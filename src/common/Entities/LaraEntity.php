<?php

namespace Lara\Common\Entities;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Lara\Common\Models\Entity;
use Lara\Common\Models\EntityCustomField;
use Lara\Common\Models\EntityRelation;
use Lara\Common\Models\EntityView;

/**
 * Frontend accessor for one entity's configuration.
 *
 * All configuration now comes from EntityRegistry, so this class holds no cache
 * of its own. The getters are thin delegations to the EntityConfig DTO and are
 * kept for the existing call sites; new code should prefer config() and read
 * the grouped option objects directly.
 */
class LaraEntity
{
    public ?string $resource_slug = null;

    protected ?string $module = null;

    protected ?string $prefix = null;

    protected ?string $method = null;

    protected ?EntityConfig $config = null;

    /**
     * Entities without a row of their own (search, users, …) get no config, and every
     * config-based check then returns its default.
     */
    public function __construct()
    {
        $this->config = app(EntityRegistry::class)->find((string) $this->resource_slug);
    }

    /**
     * The immutable configuration for this entity.
     */
    public function config(): ?EntityConfig
    {
        return $this->config;
    }

    /**
     * The underlying Eloquent model.
     */
    public function getEntity(): ?Entity
    {
        return $this->config?->model();
    }

    public function getModule(): ?string
    {
        return $this->module;
    }

    public function getResourceSlug(): ?string
    {
        return $this->config?->resourceSlug;
    }

    public function getEntityId(): int
    {
        return (int) $this->config?->id;
    }

    public function getEntityTitle(): ?string
    {
        return $this->config?->title;
    }

    public function getLabelSingle(): ?string
    {
        return $this->config?->labelSingle;
    }

    public function getResource(): ?string
    {
        return $this->config?->resourceClass;
    }

    public function getPolicy(): ?string
    {
        return $this->config?->policyClass;
    }

    public function getEntityModelClass(): ?string
    {
        return $this->config?->modelClass;
    }

    public function getEntityController(): ?string
    {
        return $this->config?->controller;
    }

    public function getNavGroup(): ?string
    {
        return $this->config?->navGroup;
    }

    public function getNavPosition(): ?int
    {
        return $this->config?->navPosition;
    }

    public function getCgroup(): ?string
    {
        return $this->config?->cgroup;
    }

    // content

    public function hasLead(): bool
    {
        return (bool) $this->config?->content->hasLead;
    }

    public function hasBody(): bool
    {
        return (bool) $this->config?->content->hasBody;
    }

    public function getMaxBodyFields(): int
    {
        return (int) $this->config?->content->extraBodyFields;
    }

    public function hasStatus(): bool
    {
        return (bool) $this->config?->content->hasStatus;
    }

    public function hasExpiration(): bool
    {
        return (bool) $this->config?->content->hasExpiration;
    }

    public function hasHideinlist(): bool
    {
        return (bool) $this->config?->content->hasHideInList;
    }

    public function showRichLead(): bool
    {
        return (bool) $this->config?->content->richLead;
    }

    public function showRichBody(): bool
    {
        return (bool) $this->config?->content->richBody;
    }

    // sort order

    public function isSortable(): bool
    {
        return (bool) $this->config?->sort->isSortable;
    }

    public function getPrimarySortField(): string
    {
        return $this->config?->sort->primaryField ?? 'id';
    }

    public function getPrimarySortOrder(): string
    {
        return $this->config?->sort->primaryOrder ?? 'asc';
    }

    public function getSecondarySortField(): ?string
    {
        return $this->config?->sort->secondaryField;
    }

    public function getSecondarySortOrder(): ?string
    {
        return $this->config?->sort->secondaryOrder;
    }

    // display

    public function showSearch(): bool
    {
        return (bool) $this->config?->display->showSearch;
    }

    public function showBatch(): bool
    {
        return (bool) $this->config?->display->showBatch;
    }

    public function showStatus(): bool
    {
        return (bool) $this->config?->display->showStatus;
    }

    public function showSeo(): bool
    {
        return (bool) $this->config?->display->showSeo;
    }

    public function showAuthor(): bool
    {
        return (bool) $this->config?->display->showAuthor;
    }

    public function showSync(): bool
    {
        return (bool) $this->config?->display->showSync;
    }

    // relations

    public function hasTerms(): bool
    {
        return (bool) $this->config?->relations->hasTerms;
    }

    /**
     * @deprecated Use hasTerms() instead.
     */
    public function hasTags(): bool
    {
        return $this->hasTerms();
    }

    public function hasGroups(): bool
    {
        return (bool) $this->config?->relations->hasGroups;
    }

    /**
     * @return list<string>
     */
    public function getGroups(): array
    {
        return $this->config?->relations->groupValues ?? [];
    }

    public function hasRelated(): bool
    {
        return (bool) $this->config?->relations->hasRelated;
    }

    public function isRelatable(): bool
    {
        return (bool) $this->config?->relations->isRelatable;
    }

    // media

    public function hasFeatured(): bool
    {
        return (bool) $this->config?->media->hasFeatured;
    }

    public function hasThumb(): bool
    {
        return (bool) $this->config?->media->hasThumb;
    }

    public function hasHero(): bool
    {
        return (bool) $this->config?->media->hasHero;
    }

    public function hasIcon(): bool
    {
        return (bool) $this->config?->media->hasIcon;
    }

    public function hasGallery(): bool
    {
        return (bool) $this->config?->media->hasGallery;
    }

    public function hasGalleryPro(): bool
    {
        return (bool) $this->config?->media->hasGalleryPro;
    }

    public function hasVideos(): bool
    {
        return (bool) $this->config?->media->hasVideos;
    }

    public function hasVideoFiles(): bool
    {
        return (bool) $this->config?->media->hasVideoFiles;
    }

    public function hasFiles(): bool
    {
        return (bool) $this->config?->media->hasFiles;
    }

    public function hasImages(): bool
    {
        return (bool) $this->config?->media->hasMainImages();
    }

    public function getMaxGallery(): int
    {
        return (int) $this->config?->media->maxGallery;
    }

    public function getMaxVideos(): int
    {
        return (int) $this->config?->media->maxVideos;
    }

    public function getMaxVideoFiles(): int
    {
        return (int) $this->config?->media->maxVideoFiles;
    }

    public function getMaxFiles(): int
    {
        return (int) $this->config?->media->maxFiles;
    }

    public function getImageDisk(): ?string
    {
        return $this->config?->media->imageDisk;
    }

    public function getVideoDisk(): ?string
    {
        return $this->config?->media->videoDisk;
    }

    public function getFileDisk(): ?string
    {
        return $this->config?->media->fileDisk;
    }

    public function getImageUrl(string $filename): string
    {
        return Storage::disk($this->getImageDisk())->url($filename);
    }

    public function getVideoUrl(string $filename): string
    {
        return Storage::disk($this->getVideoDisk())->url($filename);
    }

    public function getFileUrl(string $filename): string
    {
        return Storage::disk($this->getFileDisk())->url($filename);
    }

    // sub-resources

    /**
     * @return Collection<int, EntityCustomField>
     */
    public function getCustomColumns(): Collection
    {
        return $this->config?->customFields() ?? new Collection;
    }

    /**
     * @return Collection<int, EntityView>
     */
    public function getViews(): Collection
    {
        return $this->config?->views() ?? new Collection;
    }

    /**
     * @return Collection<int, EntityRelation>
     */
    public function getRelations(): Collection
    {
        return $this->config?->entityRelations() ?? new Collection;
    }
}
