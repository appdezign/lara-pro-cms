<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Lara\Common\Models\Menu;
use Lara\Common\Models\MenuItem;
use Lara\Common\Models\Page;

use Cache;
use Lara\Common\Models\Tag;

trait HasFrontMenu
{

	/**
	 * Get the HomePage
	 *
	 * @param string $language
	 * @return Page|null
	 */
	private function getHomePage(string $language)
	{

		$mainMenuID = $this->getMainMenuId();
		if ($mainMenuID) {
			$homeMenuItem = MenuItem::langIs($language)
				->menuIs($mainMenuID)
				->whereNull('parent_id')
				->where('is_home', 1)
				->first();
			if ($homeMenuItem && $homeMenuItem->object_id) {
				return Page::find($homeMenuItem->object_id);
			} else {
				return null;
			}
		} else {
			return null;
		}

	}

	/**
	 * Check if the main menu exists
	 * If not, create it
	 *
	 * @return int
	 */
	private function getMainMenuId()
	{

		$mainMenu = Menu::where('slug', 'main')->first();

		if (empty($mainMenu)) {

			// create main menu
			$newMainMenu = Menu::create([
				'title' => 'Main',
				'slug'  => 'main',
			]);

			return $newMainMenu->id;

		} else {

			return $mainMenu->id;
		}

	}

	/**
	 * Get the full path of the active menu item
	 *
	 * @param bool $getIdOnly
	 * @return array
	 */
	private function getActiveMenuArray($getIdOnly = false)
	{

		$base_url = URL::to('/');
		$slug = substr(URL::current(), strlen($base_url));
		$route = substr($slug, 4);
		$language = substr($slug, 1, 2);
		$routename = $this->getRouteFromSlug($slug);

		$activeMenuArray = array();

		if ($routename == 'special.home.show') {

			// HOME PAGE
			$activeMenuItem = MenuItem::where('routename', $routename)->first();

			if ($activeMenuItem) {

				// add current menu item
				if ($getIdOnly) {
					$activeMenuArray[] = $activeMenuItem->id;
				} else {
					$activeMenuArray[] = $activeMenuItem;
				}

			}

		} else {

			$routeparts = explode('.', $routename);

			if (end($routeparts) == 'show') {

				// detail page, get parent
				$routepos = strrpos($route, '/');
				$route = substr($route, 0, $routepos);

				$rnamepos = strrpos($routename, '.');
				$routename = substr($routename, 0, $rnamepos);

			} else {

				// remove tags from routename
				$prefix = $routeparts[0];
				$resourceSlug = $routeparts[1];
				$method = end($routeparts);
				$routename = $prefix . '.' . $resourceSlug . '.' . $method;

			}

			// find by url
			$activeMenuItem = MenuItem::langIs($language)->where('route', $route)->first();

			if (!$activeMenuItem) {
				// find by routename
				$activeMenuItem = MenuItem::langIs($language)->where('routename', $routename)->first();
			}

			if ($activeMenuItem) {

				// add current menu item
				if ($getIdOnly) {
					$activeMenuArray[] = $activeMenuItem->id;
				} else {
					$activeMenuArray[] = $activeMenuItem;
				}

				// add parents
				$activeMenuArray = $this->getMenuParent($activeMenuItem, $activeMenuArray, $getIdOnly);

			}

		}

		return $activeMenuArray;

	}

	/**
	 * Get the Laravel route name from the given url
	 *
	 * @param string $url
	 * @return mixed
	 */
	private function getRouteFromSlug(string $slug)
	{

		$route = app('router')->getRoutes()->match(app('request')->create($slug))->getName();

		return $route;

	}


	private function getMenuTag(string $language, object $entity, Request $request)
	{

		// NOTE: v10

		$tag = null;

		if ($entity->getCgroup() == 'entity') {
			$activeMenuItem = $this->getActiveMenuItem($language);
			if ($activeMenuItem) {
				$tag_id = $activeMenuItem->tag_id;
				if ($tag_id) {
					$tag = Tag::find($tag_id);
				}
			}
		}

		return $tag;

	}

	private function getSingleMenuTag(string $language, object $entity, Request $request)
	{

		if ($entity->getCgroup() == 'entity') {

			$defaultTaxonomy = $this->getFrontDefaultTaxonomy();
			$tax = $defaultTaxonomy->slug;

			if ($request->has($tax)) {

				$tagSlug = $request->get($tax);
				$tag = Tag::where('taxonomy_id', $defaultTaxonomy->id)->where('slug', $tagSlug)->first();
				if ($tag) {
					return $tag;
				} else {
					return null;
				}
			} else {
				return null;
			}

		} else {
			return null;
		}

	}

	/**
	 * Get the active Menu Item object, based on the current url
	 *
	 * @param string $language
	 * @return mixed
	 */
	private function getActiveMenuItem(string $language)
	{
		// NOTE: v10

		$base_url = URL::to('/');
		$slug = substr(URL::current(), strlen($base_url));
		$routename = $this->getRouteFromUrl($slug);
		$url = substr($slug, 4);

		if ($routename == 'special.home.show') {

			$activeMenuItem = MenuItem::langIs($language)->where('routename', $routename)->first();

		} else {

			// Get parent routename
			$routename = $this->getParentRoutename($routename);

			// Get parent url
			$url = $this->getParentUrl($routename, $url);

			// Find by URL
			$activeMenuItem = MenuItem::langIs($language)->where('route', $url)->first();

			if (empty($activeMenuItem)) {
				// Find by routename
				$activeMenuItem = MenuItem::langIs($language)->where('routename', $routename)->first();
			}

		}

		return $activeMenuItem;

	}

	/**
	 * @param $routename
	 * @return string
	 */
	private function getParentRoutename($routename)
	{
		// NOTE: v10

		$routeparts = explode('.', $routename);
		if (end($routeparts) == 'show') {
			$rnamepos = strrpos($routename, '.');
			$routename = substr($routename, 0, $rnamepos);
		} else {
			// remove tags from routename
			$prefix = $routeparts[0];
			$resourceSlug = $routeparts[1];
			$method = end($routeparts);
			$routename = $prefix . '.' . $resourceSlug . '.' . $method;
		}

		return $routename;
	}

	/**
	 * @param $routename
	 * @param $url
	 * @return string
	 */
	private function getParentUrl($routename, $url)
	{
		// NOTE: v10

		$routeparts = explode('.', $routename);

		if (end($routeparts) == 'show') {
			$urlpos = strrpos($url, '/');
			$url = substr($url, 0, $urlpos);
		}

		return $url;
	}

	/**
	 * Get the parent Menu item object (recursive)
	 *
	 * @param object $menuitem
	 * @param array $menuarray
	 * @param bool $getIdOnly
	 * @return mixed
	 */
	private function getMenuParent(object $menuitem, array $menuarray, bool $getIdOnly = false)
	{

		if (!empty($menuitem->parent_id)) {

			$parent = MenuItem::where('id', $menuitem->parent_id)->first();

			if (!empty($parent)) {

				if ($getIdOnly) {
					$menuarray[] = $parent->id;
				} else {
					$menuarray[] = $parent;
				}

				// recursive
				if (!empty($parent->parent_id)) {
					$menuarray = $this->getMenuParent($parent, $menuarray, $getIdOnly);
				}

			}

		}

		return $menuarray;

	}

	/**
	 * Get all the routes from the main menu,
	 * and pass these routes to all the views,
	 * so we can access the routes from blade views.
	 *
	 * Examples for a read-more button (blade):
	 * {{ route($data->eroutes['page']['about']) }}
	 * {{ route($data->eroutes['entity']['blog']) }}
	 *
	 * @param string $language
	 * @return mixed
	 */
	private function getMenuEntityRoutes(string $language)
	{

		$cache_key = 'front_menu_entity_routes';

		return Cache::rememberForever($cache_key, function () use ($language) {

			$mainMenuID = $this->getMainMenuId();

			$menu_array = array();

			// entities
			$entitymenu = MenuItem::langIs($language)
				->menuIs($mainMenuID)
				->get();

			foreach ($entitymenu as $item) {

				if ($item->type->value == 'entity') {
					$menu_array['entity'][$item->entity->resource_slug] = $item->routename;
				}
				if ($item->type->value == 'page') {
					$menu_array['page'][$item->slug] = 'entity.pages.show.' . $item->object_id;
				}
				if ($item->type->value == 'form') {
					$menu_array['form'][$item->slug] = $item->routename;
				}
			}

			return $menu_array;

		});

	}

	private function getPageChildren($language)
	{

		$collection = collect();

		$activeMenu = $this->getActiveMenuArray(true);

		if ($activeMenu) {

			$activeMenuId = $activeMenu[0];
			$menu = Menu::where('slug', 'main')->first();

			if ($menu) {

				$activeMenuObject = MenuItem::langIs($language)
					->menuIs($menu->id)
					->where('id', $activeMenuId)
					->first();

				if ($activeMenuObject) {

					$depth = $activeMenuObject->depth + 1;

					$submenu = MenuItem::scoped(['menu_id' => $menu->id, 'language' => $this->language])
						->defaultOrder()
						->withDepth()
						->having('depth', '=', $depth)
						->where('publish', 1)
						->descendantsOf($activeMenuObject->id)
						->toArray();

					foreach ($submenu as $menuitem) {
						if ($menuitem['type'] == 'page') {
							$pageid = $menuitem['object_id'];
							$page = Page::find($pageid);
							if ($page) {
								// add page to collection
								$collection->push($page);

							}
						}
					}
				}
			}

			return $collection;

		} else {
			return null;
		}

	}

}
