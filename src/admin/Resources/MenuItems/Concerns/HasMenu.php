<?php

namespace Lara\Admin\Resources\MenuItems\Concerns;

use Carbon\Carbon;
use Filament\Forms\Components\Fieldset;
use Lara\Admin\Resources\LaraMenuItemResource\Pages\LaraListMenuItems;
use Lara\Common\Models\Entity;
use Lara\Common\Models\EntityView;
use Lara\Common\Models\Menu;
use Lara\Common\Models\MenuItem;
use Lara\Common\Models\Page;
use function Lara\Admin\Traits\createNewPage;

trait HasMenu
{

	private static function mutateMenuFormDataBeforeFill($data)
	{
		$type = $data['type'];

		if ($type == 'form') {
			$data['entity_form_view_id'] = $data['entity_view_id'];
		}

		return $data;
	}

	private static function mutateMenuFormDataBeforeSave($data)
	{

		$typeObject = $data['type'];
		$type = $typeObject->value;

		if ($type == 'page') {

			// PAGE
			$entity = Entity::where('resource_slug', 'pages')->first();
			if ($entity) {
				$data['entity_id'] = $entity->id;
			}
			$view = $entity->views()->isSingle()->where('template', 'standard')->first();
			if ($view) {
				$data['entity_view_id'] = $view->id;
			}
			$data['tag_id'] = null;
			$data['url'] = null;

			if ($data['object_id'] == 'new') {

				// create new page
				$newPageId = static::createNewPage(auth()->id(), $data['language'], $data['title'], 'page');
				$data['object_id'] = $newPageId;
			}

		} elseif ($type == 'parent') {

			// PARENT
			$data['entity_id'] = null;
			$data['entity_view_id'] = null;
			$data['object_id'] = null;
			$data['tag_id'] = null;
			$data['url'] = null;

		} elseif ($type == 'entity') {

			// MODULE
			$viewId = $data['entity_view_id'];
			$view = EntityView::find($viewId);
			if ($view) {
				$data['entity_id'] = $view->entity_id;
			}
			$data['object_id'] = null;
			$data['url'] = null;

		} elseif ($type == 'form') {
			$viewId = $data['entity_form_view_id'];
			ray($viewId);
			$data['entity_view_id'] = $viewId;
			$view = EntityView::find($viewId);
			ray($view);
			if ($view) {
				ray($view->entity_id);
				$data['entity_id'] = $view->entity_id;
			}
			$data['object_id'] = null;
			$data['url'] = null;

			ray($data);
		} elseif ($type == 'url') {
			$data['entity_id'] = null;
			$data['entity_view_id'] = null;
			$data['object_id'] = null;
			$data['tag_id'] = null;
		}

		return $data;

	}

	private static function processMenuNodes($language, $menuId): void
	{

		$menu = Menu::find($menuId);

		if ($menu) {

			$collection = MenuItem::scoped(['language' => $language, 'menu_id' => $menu->id])
				->defaultOrder()
				->get();

			$tree = $collection->toTree();

			foreach ($tree as $node) {
				static::processMenuNode($node);
			}

			// save sort order
			$array = $collection->toArray();
			$position = $menu->id * 1000 + 1;
			foreach ($array as $item) {
				$menuItemId = $item['id'];
				$menuItem = MenuItem::find($menuItemId);
				$menuItem->position = $position;
				$menuItem->save();
				$position++;
			}

		}
	}

	private static function processMenuNode(object $node, ?string $parentRoute = null, bool $forceAuth = false): void
	{

		// depth
		$node->depth = sizeof($node->ancestors);

		// route
		if ($node->is_home) {
			$node->route = null;
		} else {
			if ($node->type->value == 'url') {
				$node->route = null;
			} elseif ($node->depth == 0) {
				$node->route = $node->slug;
			} else {
				$node->route = $parentRoute . '/' . $node->slug;
			}
		}

		// front auth
		if ($forceAuth) {
			$node->route_has_auth = 1;
		}

		// route name
		$node->routename = null;
		$entityView = EntityView::find($node->entity_view_id);
		$entity = Entity::find($node->entity_id);
		if ($node->type->value == 'page') {
			$prefix = 'entity';
			$node->routename = $prefix . '.' . $entity->resource_slug . '.' . $entityView->method . '.' . $node->object_id;
		} elseif ($node->type->value == 'entity') {
			$prefix = ($entity->objrel_has_terms) ? 'entitytag' : 'entity';
			$node->routename = $prefix . '.' . $entity->resource_slug . '.' . $entityView->method;
		} elseif ($node->type->value == 'form') {
			$prefix = 'form';
			$node->routename = $prefix . '.' . $entity->resource_slug . '.' . $entityView->method;
		}

		$node->save();

		if ($node->type->value == 'parent') {
			if ($node->route_has_auth == 1) {
				$forceAuth = true;
			}
		}

		foreach ($node->children as $child) {
			static::processMenuNode($child, $node->route, $forceAuth);
		}

	}

	private static function saveMenuItemPositions($clanguage, $menuId): void
	{
		$tree = MenuItem::scoped(['language' => $clanguage, 'menu_id' => $menuId])
			->defaultOrder()
			->get()
			->toArray();

		$counter = $menuId * 1000 + 1;
		foreach ($tree as $item) {
			$menuItem = MenuItem::find($item['id']);
			$menuItem->position = $counter;
			$menuItem->save();
			$counter++;
		}

	}

	private static function treeIsValid($data): bool
	{
		if (static::checkHome($data[0]['id'])) {
			return true;
		} else {
			foreach ($data as $item) {
				if (static::checkHome($item['id'])) {
					return false;
				}
				foreach ($item['children'] as $child) {
					if (static::checkHome($child['id'])) {
						return false;
					}
				}
			}

			return true;
		}
	}

	private static function checkHome($menuItemId)
	{
		$menuItem = MenuItem::find($menuItemId);
		if ($menuItem) {
			return (bool)$menuItem->is_home;
		}
	}

	private static function checkModulePage($menuItem): void
	{

		$cgroup = 'entity';

		if ($menuItem->type->value == $cgroup) {

			$entity = Entity::find($menuItem->entity_id);
			$entityView = EntityView::find($menuItem->entity_view_id);

			if ($entity && $entityView) {

				$slug = $entity->resource_slug . '-' . $entityView->method . '-' . $cgroup . '-' . $menuItem->language;
				$modulePage = Page::langIs($menuItem->language)->where('cgroup', $cgroup)->where('slug', $slug)->first();

				if (empty($modulePage)) {

					// create Module Page
					$title = ucfirst($entity->resource_slug) . ' ' . ucfirst($entityView->method) . ' ' . ucfirst($cgroup) . ' Page';

					$newModulePage = static::createNewPage(auth()->id(), $menuItem->language, $title, $cgroup, $slug);

				}

			}
		}

	}

	private static function createNewPage(int $userId, string $language, string $title, string $cgroup, string $slug = null, string $template = 'standard', int $publish = 1)
	{
		$newPage = Page::create([
			'user_id'      => $userId,
			'language'     => $language,
			'slug'         => $slug,
			'title'        => $title,
			'template'     => $template,
			'publish'      => $publish,
			'publish_from' => Carbon::now(),
			'cgroup'       => $cgroup,
		]);

		return $newPage->id;
	}
}
