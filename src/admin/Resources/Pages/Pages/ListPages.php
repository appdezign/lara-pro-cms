<?php

namespace Lara\Admin\Resources\Pages\Pages;

use Illuminate\Support\Facades\DB;
use Lara\Admin\Pages\Lara\LaraListRecords;
use Lara\Admin\Resources\Pages\PageResource;

use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasParams;
use Lara\Common\Models\MenuItem;
use Lara\Common\Models\Page;

class ListPages extends LaraListRecords
{
	use HasLanguage;
	use HasParams;

	protected static ?string $clanguage = null;

	protected static string $resource = PageResource::class;

	public function mount(): void
	{
		parent::mount();

		static::setContentLanguage();

		static::syncPagesWithMenu();
	}

	private static function syncPagesWithMenu(): void {


		DB::table('lara_content_pages')
			->where('language', static::$clanguage)
			->update(['ishome' => 0, 'position' => 0, 'menuroute' => null]);

		// menu pages
		$menuItems = MenuItem::where('type', 'page')->get();
		foreach($menuItems as $menuItem) {
			$page = Page::find($menuItem->object_id);
			$page->position = $menuItem->position;
			$page->menuroute = '/' . $menuItem->route;
			$page->save();
		}

		// reorder module pages
		$modulePages = Page::where('cgroup', 'module')->orderBy('slug')->get();
		$i = 8001;
		foreach ($modulePages as $modulePage) {
			$modulePage->position = $i;
			$modulePage->save();
			$i++;
		}

		// reorder uncategorized pages
		$pages = Page::where('position', 0)->get();
		$i = 9001;
		foreach ($pages as $page) {
			$page->position = $i;
			$page->save();
			$i++;
		}
	}
}
