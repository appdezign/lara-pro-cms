<?php

namespace Lara\Front\Http\Concerns;


use Lara\Common\Lara\LaraEntity;
use Lara\Common\Models\MenuItem;
use Lara\Front\Http\Lara\FrontActiveRoute;
use stdClass;

trait HasFrontEntity
{

	/**
	 * Get the Lara Entity Class
	 *
	 * @param string $routename
	 * @return LaraEntity|null
	 */
	private function getFrontEntity(string $routename)
	{

		$route = $this->prepareFrontRoute($routename);
		$lara = $this->getLaraClass($route->resource_slug);

		if(class_exists($lara)) {
			return new $lara;
		} else {
			return null;
		}

	}

	/**
	 * @param string $routename
	 * @return FrontActiveRoute
	 */
	private function getLaraActiveRoute(string $routename)
	{

		$route = $this->prepareFrontRoute($routename);

		$entityRoute = new FrontActiveRoute($route);

		$entityRoute->setPrefix($route->prefix);
		$entityRoute->setMethod($route->method);

		if (isset($route->menu_id)) {
			$entityRoute->setMenuId($route->menu_id);
		}

		if (isset($route->object_id)) {
			$entityRoute->setObjectId($route->object_id);
		}

		$entityRoute->setActiveRoute($routename);

		if(isset($route->tagless_menu_id)) {

			$singleRoute = $route->prefix . '.' . $route->resource_slug . '.' . $route->tagless_menu_id;
			foreach($route->activetags as $activeTag) {
				$singleRoute .= '.' . $activeTag;
			}
			$singleRoute .= '.index.show';
			$entityRoute->setSingleRoute($singleRoute);

		} else {
			$entityRoute->setSingleRoute($routename . '.show');
		}

		if (isset($route->activetags)) {
			$entityRoute->setActiveTags($route->activetags);
		}

		return $entityRoute;

	}

	/**
	 * Get the Lara Entity Class by key
	 *
	 * @param string $resourceSlug
	 * @return mixed|null
	 */
	private function getResourceBySlug(string $resourceSlug)
	{

		$lara = $this->getLaraClass($resourceSlug);

		if ($lara) {
			$entity = new $lara;
		} else {
			$entity = null;
		}

		return $entity;

	}

	/**
	 * Translate entity key to an FQN
	 *
	 * @param string $resourceSlug
	 * @return string
	 */
	private function getLaraClass(string $resourceSlug)
	{

		$laraClass = '\Lara\Common\Lara\\' . ucfirst($resourceSlug) . 'Entity';

		if (!class_exists($laraClass)) {

			$laraClass = '\Lara\App\Lara\\' . ucfirst($resourceSlug) . 'Entity';

			if (!class_exists($laraClass)) {

				$laraClass = null;

			}

		}

		return $laraClass;

	}

	/**
	 * @param string $routename
	 * @return stdClass
	 */
	private function prepareFrontRoute(string $routename = null)
	{

		$route = new stdClass();

		if (empty($routename)) {

			$route = $this->getDefaultRoute();

		} else {

			$parts = explode('.', $routename);

			if ($parts[0] == 'special') {

				$route = $this->getSpecialRoute($parts);

			} else {

				if($parts[0] == 'content') {
					$route = $this->getContentRoute($routename, $parts);
				} elseif($parts[0] == 'contenttag') {
					$route = $this->getContentTagRoute($routename, $parts);
				} elseif($parts[0] == 'entity') {
					$route = $this->getEntityRoute($routename, $parts);
				} elseif ($parts[0] == 'entitytag') {
					$route = $this->getEntityTagRoute($routename, $parts);
				}elseif ($parts[0] == 'form') {
					$route = $this->getFormRoute($routename, $parts);
				}

			}

		}

		return $route;

	}

	private function getContentTagRoute($routename, $parts) {

		$route = new stdClass();

		$route->prefix = $parts[0];
		$route->resource_slug = $parts[1];
		$route->method = end($parts);
		$route->activetags = array();

		if (end($parts) == 'show') {
			for ($i = 2; $i < (sizeof($parts) - 2); $i++) {
				$route->activetags[] = $parts[$i];
			}
			// $route->parent_route = substr($routename, 0, -5);
		} else {
			for ($i = 2; $i < (sizeof($parts) - 1); $i++) {
				$route->activetags[] = $parts[$i];
			}
		}
		return $route;
	}

	private function getEntityTagRoute($routename, $parts) {

		$route = new stdClass();

		$route->prefix = $parts[0];
		$route->resource_slug = $parts[1];
		$route->menu_id = $parts[2];
		$route->method = end($parts);
		$route->activetags = array();

		if (end($parts) == 'show') {
			for ($i = 3; $i < (sizeof($parts) - 2); $i++) {
				$route->activetags[] = $parts[$i];
			}
			// $route->parent_route = substr($routename, 0, -5);
		} else {
			for ($i = 3; $i < (sizeof($parts) - 1); $i++) {
				$route->activetags[] = $parts[$i];
			}
		}

		$menuItem = MenuItem::find($route->menu_id);
		if($menuItem && $menuItem->tag_id) {
			// find parent menu id
			$parentMenuItem = MenuItem::where('entity_id', $menuItem->entity_id)
				->where('entity_view_id', $menuItem->entity_view_id)
				->whereNull('tag_id')
				->first();
			if($parentMenuItem) {
				$route->tagless_menu_id = $parentMenuItem->id;
			} else {
				dd('create parent menu item');
			}
		}

		return $route;
	}

	private function getContentRoute($routename, $parts) {

		$route = new stdClass();

		if (sizeof($parts) == 3) {

			// get prefix, model and method from route
			list($route->prefix, $route->resource_slug, $route->method) = explode('.', $routename);

		}

		if (sizeof($parts) == 4) {

			if (end($parts) == 'show') {

				// get prefix, model, parent-method, and method from route
				list($route->prefix, $route->resource_slug, $route->parent_method, $route->method) = explode('.', $routename);
				// $route->parent_route = $route->prefix . '.' . $route->resource_slug . '.' . $route->parent_method;

			} else {

				// get prefix, model, method and id from route
				list($route->prefix, $route->resource_slug, $route->menu_id, $route->method, $route->object_id) = explode('.', $routename);

			}

		}

		return $route;
	}

	private function getEntityRoute($routename, $parts) {

		$route = new stdClass();

		if (sizeof($parts) == 4) {

			// get prefix, model and method from route
			list($route->prefix, $route->resource_slug, $route->menu_id, $route->method) = explode('.', $routename);

		}

		if (sizeof($parts) == 5) {

			if (end($parts) == 'show') {

				// get prefix, model, parent-method, and method from route
				list($route->prefix, $route->resource_slug, $route->menu_id, $route->parent_method, $route->method) = explode('.', $routename);
				// $route->parent_route = $route->prefix . '.' . $route->resource_slug . '.' . $route->parent_method;

			} else {

				// get prefix, model, method and id from route
				list($route->prefix, $route->resource_slug, $route->menu_id, $route->method, $route->object_id) = explode('.', $routename);

			}

		}

		return $route;
	}



	private function getFormRoute($routename, $parts) {

		$route = new stdClass();

		if (sizeof($parts) == 4) {
			list($route->prefix, $route->resource_slug, $route->menu_id, $route->method) = explode('.', $routename);
		}

		return $route;
	}

	private function getSpecialRoute($parts) {

		$route = new stdClass();

		if ($parts[1] == 'home') {
			$route->prefix = 'entity';
			$route->resource_slug = 'pages';
			$route->method = 'show';
		}

		if ($parts[1] == 'search') {
			$route->prefix = 'special';
			$route->resource_slug = 'search';
			$route->method = end($parts);
		}

		if ($parts[1] == 'user') {
			$route->prefix = 'special';
			$route->resource_slug = 'users';
			$route->method = end($parts);
		}

		return $route;

	}

	private function getDefaultRoute() {

		$route = new stdClass();

		$route->prefix = 'entity';
		$route->resource_slug = 'pages';
		$route->method = 'show';

		return $route;
	}

}
