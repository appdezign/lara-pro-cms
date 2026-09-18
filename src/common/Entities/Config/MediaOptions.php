<?php

namespace Lara\Common\Entities\Config;

use Lara\Common\Models\Entity;

/**
 * Media options for an entity (the `media_*` columns).
 */
final readonly class MediaOptions
{

	public function __construct(
		public bool $hasFeatured,
		public bool $hasThumb,
		public bool $hasHero,
		public bool $hasIcon,
		public bool $hasGallery,
		public bool $hasGalleryPro,
		public bool $hasVideos,
		public bool $hasVideoFiles,
		public bool $hasFiles,
		public int $maxGallery,
		public int $maxVideos,
		public int $maxVideoFiles,
		public int $maxFiles,
		public ?string $imageDisk,
		public ?string $videoDisk,
		public ?string $fileDisk,
	) {}

	public static function fromEntity(Entity $entity): self
	{
		return new self(
			hasFeatured: (bool) $entity->media_has_featured,
			hasThumb: (bool) $entity->media_has_thumb,
			hasHero: (bool) $entity->media_has_hero,
			hasIcon: (bool) $entity->media_has_icon,
			hasGallery: (bool) $entity->media_has_gallery,
			hasGalleryPro: (bool) $entity->media_has_gallery_pro,
			hasVideos: (bool) $entity->media_has_videos,
			hasVideoFiles: (bool) $entity->media_has_videofiles,
			hasFiles: (bool) $entity->media_has_files,
			maxGallery: (int) $entity->media_max_gallery,
			maxVideos: (int) $entity->media_max_videos,
			maxVideoFiles: (int) $entity->media_max_videofiles,
			maxFiles: (int) $entity->media_max_files,
			imageDisk: $entity->media_disk_images,
			videoDisk: $entity->media_disk_videos,
			fileDisk: $entity->media_disk_files,
		);
	}

	/**
	 * Whether any of the single "main" image slots is enabled.
	 */
	public function hasMainImages(): bool
	{
		return $this->hasFeatured || $this->hasThumb || $this->hasHero || $this->hasIcon;
	}

	/**
	 * Whether any image slot at all is enabled, including the gallery.
	 */
	public function hasAnyImages(): bool
	{
		return $this->hasMainImages() || $this->hasGallery;
	}

}
