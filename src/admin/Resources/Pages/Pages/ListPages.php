<?php

namespace Lara\Admin\Resources\Pages\Pages;

use Illuminate\Support\Facades\DB;
use Lara\Admin\Concerns\HasLanguage;
use Lara\Admin\Concerns\HasParams;
use Lara\Admin\Pages\Lara\LaraListRecords;
use Lara\Admin\Resources\Pages\PageResource;
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

    /**
     * Sync the menu position, menu route and home flag of the pages of the content language.
     *
     * Menu pages get the position and route of their menu item, module pages 8001 and up
     * (by slug), the other pages 9001 and up. Only values that change are written, without
     * observers or timestamps, so opening the list does not touch every page.
     */
    private static function syncPagesWithMenu(): void
    {
        $language = static::$clanguage;

        $pages = Page::langIs($language)->orderBy('id')->get(['id', 'cgroup', 'slug', 'position', 'menuroute', 'ishome']);

        /** @var array<int, array{ishome: int, position: int, menuroute: ?string}> $targets */
        $targets = [];
        foreach ($pages as $page) {
            $targets[$page->id] = ['ishome' => 0, 'position' => 0, 'menuroute' => null];
        }

        // menu pages; a menu item whose page is gone is skipped
        $menuItems = MenuItem::langIs($language)->where('type', 'page')->get();
        foreach ($menuItems as $menuItem) {
            if (! isset($targets[$menuItem->object_id])) {
                continue;
            }

            $targets[$menuItem->object_id] = [
                'ishome' => (int) $menuItem->is_home,
                'position' => (int) $menuItem->position,
                'menuroute' => '/'.$menuItem->route,
            ];
        }

        // module pages
        $position = 8001;
        foreach ($pages->where('cgroup', 'module')->sortBy('slug') as $modulePage) {
            $targets[$modulePage->id]['position'] = $position++;
        }

        // uncategorized pages
        $position = 9001;
        foreach ($targets as $pageId => $target) {
            if ($target['position'] === 0) {
                $targets[$pageId]['position'] = $position++;
            }
        }

        foreach ($pages as $page) {
            $target = $targets[$page->id];

            $isChanged = (int) $page->ishome !== $target['ishome']
                || (int) $page->position !== $target['position']
                || $page->menuroute !== $target['menuroute'];

            if ($isChanged) {
                DB::table($page->getTable())->where('id', $page->id)->update($target);
            }
        }
    }
}
