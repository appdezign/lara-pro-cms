<?php

namespace Lara\Admin\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Lara\Admin\Resources\Tags\TagResource;
use Lara\Admin\Resources\Tags\Pages\ListTags;
use Lara\Admin\Traits\HasFilters;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasParams;
use Lara\Admin\Traits\HasReorder;
use Lara\Common\Models\Tag;
use Lara\Common\Models\Taxonomy;
use Livewire\Component;

use Lara\Admin\Traits\HasTerms;

class LaraTagReorder extends Component
{
	use HasFilters;
	use HasReorder;
	use HasLanguage;
	use HasParams;
	use HasTerms;

	protected static string $resource = TagResource::class;

	protected static ?string $clanguage = null;

	public array $data = [];

	public function mount(): void
	{

	}

	public function render()
	{

		$taxonomyId = static::getActiveFilterFromPage(ListTags::class, 'taxonomy_id');
		$taxonomy = Taxonomy::find($taxonomyId);
		$hasHierarchy = $taxonomy->has_hierarchy;

		$viewPostfix = ($hasHierarchy) ? 'nested' : 'list';
		return view('lara-admin::livewire.lara-tag-reorder-' . $viewPostfix, [
			'items' => $this->items(),
		]);
	}

	public function items(): Collection
	{

		static::setContentLanguage();
		$resourceSlug = static::getActiveFilterFromPage(ListTags::class, 'resource_slug');
		$taxonomyId = static::getActiveFilterFromPage(ListTags::class, 'taxonomy_id');

		return Tag::scoped(['language' => static::$clanguage, 'resource_slug' => $resourceSlug, 'taxonomy_id' => $taxonomyId])
			->defaultOrder()
			->get()
			->toTree();
	}

	public function save(): void
	{
		if (empty($this->data)) {
			return;
		}

		Tag::rebuildTree($this->data);

		static::setContentLanguage();
		$resourceSlug = static::getActiveFilterFromPage(ListTags::class, 'resource_slug');
		$taxonomyId = static::getActiveFilterFromPage(ListTags::class, 'taxonomy_id');

		static::processTagNodes(static::$clanguage, $resourceSlug, $taxonomyId);

		Notification::make()
			->title(_q('lara-admin::tags.message.reorder_saved'))
			->success()
			->send();
	}

}
