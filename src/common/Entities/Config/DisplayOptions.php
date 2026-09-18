<?php

namespace Lara\Common\Entities\Config;

use Lara\Common\Models\Entity;

/**
 * Panel display options for an entity (the `show_*` columns, excluding the
 * rich-editor toggles which belong to ContentOptions).
 */
final readonly class DisplayOptions
{

	public function __construct(
		public bool $showSearch,
		public bool $showBatch,
		public bool $showStatus,
		public bool $showSeo,
		public bool $showOpenGraph,
		public bool $showAuthor,
		public bool $showSync,
		public bool $showViewAction,
		public bool $showEditAction,
		public bool $showDeleteAction,
		public bool $showRestoreAction,
	) {}

	public static function fromEntity(Entity $entity): self
	{
		return new self(
			showSearch: (bool) $entity->show_search,
			showBatch: (bool) $entity->show_batch,
			showStatus: (bool) $entity->show_status,
			showSeo: (bool) $entity->show_seo,
			showOpenGraph: (bool) $entity->show_opengraph,
			showAuthor: (bool) $entity->show_author,
			showSync: (bool) $entity->show_sync,
			showViewAction: (bool) $entity->show_view_action,
			showEditAction: (bool) $entity->show_edit_action,
			showDeleteAction: (bool) $entity->show_delete_action,
			showRestoreAction: (bool) $entity->show_restore_action,
		);
	}

}
