<?php

namespace Lara\Front\Http\Concerns;


use Lara\Common\Lara\LaraEntity;
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

		if (isset($route->object_id)) {
			$entityRoute->setObjectId($route->object_id);
		}

		$entityRoute->setActiveRoute($routename);

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

			// assume this is a Page
			$route->prefix = 'entity';
			$route->resource_slug = 'pages';
			$route->method = 'show';

		} else {

			$parts = explode('.', $routename);

			if ($parts[0] == 'special') {

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

			} else {

				if ($parts[0] == 'entitytag' || $parts[0] == 'contenttag') {

					if (end($parts) == 'show') {

						$route->prefix = $parts[0];
						$route->resource_slug = $parts[1];
						$route->method = end($parts);

						$route->activetags = array();

						for ($i = 2; $i < (sizeof($parts) - 2); $i++) {
							$route->activetags[] = $parts[$i];
						}

						$route->parent_route = substr($routename, 0, -5);

					} else {

						$route->prefix = $parts[0];
						$route->resource_slug = $parts[1];
						$route->method = end($parts);

						$route->activetags = array();

						for ($i = 2; $i < (sizeof($parts) - 1); $i++) {
							$route->activetags[] = $parts[$i];
						}

					}

				} else {

					if (sizeof($parts) == 3) {

						// get prefix, model and method from route
						list($route->prefix, $route->resource_slug, $route->method) = explode('.', $routename);

					}

					if (sizeof($parts) == 4) {

						if (end($parts) == 'show') {

							/**
							 * If we show an object from a list view (master > detail),
							 * then we need to be able to go back to that specific list view.
							 *
							 * To accomplish that, we add 'parent method' in the route name,
							 * and here we get it from the route name and pass it on to the entity object,
							 * which is passed on to the 'show view'
							 */

							// get prefix, model, parent-method, and method from route
							list($route->prefix, $route->resource_slug, $route->parent_method, $route->method) = explode('.', $routename);
							$route->parent_route = $route->prefix . '.' . $route->resource_slug . '.' . $route->parent_method;

						} else {

							// get prefix, model, method and id from route
							list($route->prefix, $route->resource_slug, $route->method, $route->object_id) = explode('.', $routename);

						}

					}

				}

			}

		}

		return $route;

	}


}
