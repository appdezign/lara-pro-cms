<?php

namespace Lara\Admin\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Lara\Admin\Resources\MenuItems\Concerns\HasMenu;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasParams;
use Lara\Common\Models\MenuItem;
use Livewire\Component;

class LaraMenuReorder extends Component
{
	use HasMenu;
	use HasLanguage;
	use HasParams;

	public int $menuId;

	public array $data = [];

	protected static ?string $clanguage = null;

	public function mount(int $menuId): void
	{
		$this->menuId = $menuId;
		static::setContentLanguage();
	}

	public function render()
	{
		return view('lara-admin::livewire.lara-menu-reorder', [
			'items' => $this->items(),
		]);
	}

	public function items(): Collection
	{
		static::setContentLanguage();

		return MenuItem::langIs(static::$clanguage)->where('menu_id', $this->menuId)
			->defaultOrder()
			->get()
			->toTree();
	}

	public function save(): void
	{
		if (empty($this->data)) {
			return;
		}

		if(static::treeIsValid($this->data)) {

			// set language
			static::setContentLanguage();

			// save nested set
			MenuItem::rebuildTree($this->data);

			// save sort order positions for table
			static::saveMenuItemPositions(static::$clanguage, $this->menuId);

			// process nodes
			static::processMenuNodes(static::$clanguage, $this->menuId);

			Notification::make()
				->title(_q('lara-admin::menu-reorder.message.menu_saved'))
				->success()
				->send();
		} else {
			Notification::make()
				->title(_q('lara-admin::menu-reorder.message.homepage_position_error'))
				->danger()
				->send();
		}

	}




}
