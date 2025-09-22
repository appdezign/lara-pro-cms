<?php

namespace Lara\Front\Http\Concerns;

use Lara\Common\Models\Headertag;
use Lara\Common\Models\Templatefile;
use Lara\Common\Models\Language;
use Lara\Common\Models\LaraWidget;
use Lara\Common\Models\Menu;
use Lara\Common\Models\MenuItem;
use Lara\Common\Models\Setting;

use stdClass;
use Cache;

trait hasFrontend
{

	/**
	 * Get all settings from a specific group
	 *
	 * @param string $group
	 * @return stdClass
	 */
	private function getSettingsByGroup(string $group)
	{

		$settings = Setting::where('cgroup', $group)->get();

		$object = new stdClass;

		foreach ($settings as $setting) {
			$key = $setting->key;
			$value = $setting->value;
			$object->$key = $value;
		}

		return $object;

	}

	/**
	 * Get all the language versions of an object or an entity
	 *
	 * @param string $curlang
	 * @param object $entity
	 * @param object|null $object
	 * @return array
	 */
	private function getFrontLanguageVersions(string $curlang, object $entity = null, ?object $object = null)
	{

		$versions = array();

		$languages = Language::isPublished()->get();

		foreach ($languages as $lang) {

			$version = new stdClass;

			$version->langcode = $lang->code;
			$version->langname = $lang->name;

			if ($lang->code == $curlang) {

				/*
				 * find url and route for current active page
				 */

				$version->active = true;

				if ($entity) {

					if ($entity->resource_slug == 'page') {

						// The Page entity has no index method,
						// so we should have an object here
						if (!empty($object)) {

							$menuitem = MenuItem::langIs($lang->code)
								->isPublished()
								->where('entity_id', $entity->getEntityId())
								->where('object_id', $object->id)
								->first();

							if ($menuitem) {

								$languageRoutename = $menuitem->routename;
								$languageRoute = $menuitem->route;

								$version->entity = $entity->resource_slug;
								$version->object = $object->id;
								$version->route = url($lang->code . '/' . $languageRoute);
								$version->routename = $languageRoutename;

							}

						}

					} elseif ($entity->resource_slug == 'search') {

						$version->entity = $entity->resource_slug;
						$version->object = null;
						$version->route = url($lang->code . '/search');
						$version->routename = 'special.search.form';

					} else {

						// find entity in menu

						$menuitem = MenuItem::langIs($lang->code)->isPublished()->where('entity_id', $entity->getEntityId())->first();

						if ($menuitem) {

							$languageRoutename = $menuitem->routename;
							$languageRoute = $menuitem->route;

							$version->entity = $entity->resource_slug;
							if (!empty($object)) {
								$version->object = $object->id;
								if ($entity->hasTags()) {
									$version->route = url($lang->code . '/' . $languageRoute . '/' . $object->slug . '.html');
								} else {
									$version->route = url($lang->code . '/' . $languageRoute . '/' . $object->slug);
								}
							} else {
								$version->object = null;
								$version->route = url($lang->code . '/' . $languageRoute);
							}
							$version->routename = $languageRoutename;

						}

					}
				}

			} else {

				/*
				 * find url and route for language sibling
				 */

				$sibling = null;

				$version->active = false;

				if ($object) {
					// find sibling
					$sibling = $this->getFrontLanguageSibling($object, $lang->code);
				}

				$found = false;

				if ($entity) {

					if ($entity->resource_slug == 'page') {

						// find page in menu
						if ($sibling) {

							$menuitem = MenuItem::langIs($lang->code)
								->isPublished()
								->where('entity_id', $entity->getEntityId())
								->where('object_id', $sibling->id)
								->first();

							if ($menuitem) {

								$languageRoutename = $menuitem->routename;
								$languageRoute = $menuitem->route;

								$version->entity = $entity->resource_slug;
								$version->object = $sibling->id;
								$version->route = url($lang->code . '/' . $languageRoute);
								$version->routename = $languageRoutename;

								$found = true;

							}
						}
					} elseif ($entity->resource_slug == 'search') {

						$version->entity = $entity->resource_slug;
						$version->object = null;
						$version->route = url($lang->code . '/search');
						$version->routename = 'special.search.form';

						$found = true;

					} else {

						// find entity in menu
						$menuitem = MenuItem::langIs($lang->code)->isPublished()->where('entity_id', $entity->getEntityId())->first();

						if ($menuitem) {

							$languageRoutename = $menuitem->routename;
							$languageRoute = $menuitem->route;

							$version->entity = $entity->resource_slug;
							if ($sibling) {
								$version->object = $sibling->id;
								if ($entity->hasTags()) {
									$version->route = url($lang->code . '/' . $languageRoute . '/' . $sibling->slug) . '.html';
								} else {
									$version->route = url($lang->code . '/' . $languageRoute . '/' . $sibling->slug);
								}
							} else {
								$version->object = null;
								$version->route = url($lang->code . '/' . $languageRoute);
							}
							$version->routename = $languageRoutename;

							$found = true;

						}

					}

				}

				if (!$found) {

					// fall back to homepage
					$menu = Menu::where('slug', 'main')->first();
					$menuitem = MenuItem::langIs($lang->code)->where('menu_id', $menu->id)->where('is_home', 1)->first();

					if ($menuitem) {
						$version->entity = $menuitem->entity->resource_slug;
						$version->object = $menuitem->object_id;
					} else {
						// last fall back, no homepage defined yet
						$version->entity = 'page';
						$version->object = null;
					}
					$version->route = url($lang->code . '/');
					$version->routename = 'special.home.show';

				}
			}

			$versions[] = $version;

		}

		return $versions;

	}

	/**
	 * Get a specific language version for this object
	 *
	 * @param object $object
	 * @param string $dest
	 * @return object|null
	 */
	private function getFrontLanguageSibling(object $object, string $dest)
	{

		$modelClass = get_class($object);

		// find parent
		if ($object->languageParent) {
			$parent = $object->languageParent;
		} else {
			$parent = $object;
		}

		// check if we're looking for the parent itself
		if ($parent->language == $dest) {
			return $parent;
		} else {
			// get and return sibling
			$sibling = $modelClass::langIs($dest)->where('language_parent', $parent->id)->first();
			if($sibling) {
				return $sibling;
			} else {
				return null;
			}

		}

	}

	/**
	 * @param $language
	 * @return object
	 */
	private function getGlobalWidgets($language)
	{
		return LaraWidget::where('language', $language)
			->where('is_global', 1)
			->orderBy('hook')
			->orderBy('sortorder')
			->get();

	}

	/**
	 * @return stdClass
	 */
	private function getFrontLaraVersion()
	{

		$laracomposer = file_get_contents(base_path('/laracms/core/composer.json'));
		$laracomposer = json_decode($laracomposer, true);
		$laraVersionStr = $laracomposer['version'];

		$laraversion = new stdClass;
		$laraversion->version = $laraVersionStr;
		list($laraversion->major, $laraversion->minor, $laraversion->patch) = explode('.', $laraVersionStr);

		return $laraversion;

	}

	/**
	 * @return bool
	 */
	private function getFirstPageLoad()
	{

		if (session()->has('lara_first_page_load') && session()->get('lara_first_page_load') === true) {
			ray('found session var');
			return false;
		} else {
			session(['lara_first_page_load' => true]);
			ray('create session var');

			return true;
		}

	}

}
