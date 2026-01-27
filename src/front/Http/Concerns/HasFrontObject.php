<?php

namespace Lara\Front\Http\Concerns;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Lara\Common\Models\Entity;
use Lara\Common\Models\Menu;
use Lara\Common\Models\MenuItem;
use Lara\Common\Models\ObjectRelated;
use Lara\Common\Models\Page;
use Lara\Common\Models\Setting;
use Lara\Common\Models\User;
use Lara\Front\Http\Lara\FrontActiveRoute;
use stdClass;

trait HasFrontObject
{

	private function getSingleFrontObject(string $language, object $entity, string $slug)
	{

		$modelClass = $entity->getEntityModelClass();
		$collection = new $modelClass;

		// eager loading
		if ($entity->hasImages()) {
			$collection = $collection->with('images');
		}
		if ($entity->hasVideos()) {
			$collection = $collection->with('videos');
		}
		if ($entity->hasVideoFiles()) {
			$collection = $collection->with('videofiles');
		}
		if ($entity->hasFiles()) {
			$collection = $collection->with('files');
		}

		if (is_numeric($slug)) {
			$collection->where('id', $slug);
		} else {
			$collection->where('language', $language);
			$collection->where('slug', $slug);
		}

		$object = $collection->first();

		if ($object) {
			return $object;
		} else {
			return redirect(route('error.show.404', '404'))->send();
		}

	}

	/**
	 * @param int|null $id
	 * @param FrontActiveRoute $activeroute
	 * @return Application|RedirectResponse|Redirector|int|object|null
	 */
	private function getPageObjectId(?int $id, FrontActiveRoute $activeroute)
	{

		// first check the ID from the request (preview page)
		if ($id) {
			return $id;
		} else {
			// assume it is a page with a named route, inluding the ID !
			if (!empty($activeroute->getObjectId())) {
				return $activeroute->getObjectId();
			} else {
				return redirect(route('error.show.404', '404'))->send();
			}
		}
	}

	/**
	 * @param object $object
	 * @param object|null $menuTag
	 * @param object $modulePage
	 * @return object
	 */
	private function getHeroPage(object $object, object|null $menuTag, object $modulePage)
	{
		if ($object->hasHero()) {
			return $object;
		} else {
			if ($menuTag) {
				return $menuTag;
			} else {
				return $modulePage;
			}
		}
	}

	/**
	 * Get related objects from other entities
	 *
	 * @param $entity
	 * @param int $id
	 * @return array|null
	 */
	private function getFrontRelated($entity, int $id)
	{

		if ($entity->hasRelated()) {

			$relatedItems = ObjectRelated::where('entity_type', $entity->getEntityModelClass())
				->where('entity_id', $id)
				->first();

			$related = array();

			if ($relatedItems) {
				// Related Pages
				$relatedPages = $relatedItems->related_page_objects;
				foreach ($relatedPages as $rel) {

					$item = new stdClass;
					$object_id = $rel['page_object_id'];

					// get related object
					$object = Page::find($object_id);
					if ($object) {
						$item->title = $object->title;
						$item->route = 'content.pages.show';
						$item->params = $item->params = [
							'id' => $object->id
						];
						$item->url = null;
						$item->target = '_self';
						$related[] = $item;
					}

				}

				// Related Entity Objects
				$relatedEntityObjects = $relatedItems->related_entity_objects;

				foreach ($relatedEntityObjects as $rel) {

					$item = new stdClass;

					$object_id = $rel['object_id'];
					$resource_slug = $rel['resource_slug'];

					// get related object
					$entity = Entity::where('resource_slug', $resource_slug)->first();
					if ($entity) {
						$modelClass = $entity->model_class;
						$object = $modelClass::find($object_id);
						if ($object) {

							$item->title = $object->title;
							$item->route = $this->getFrontSeoRoute($resource_slug, 'index') . '.show';
							$item->params = [
								'slug' => $object->slug
							];
							$item->url = null;
							$item->target = '_self';

							// If the related object is a document, we need to get the document URL
							if ($resource_slug == 'docs') {
								$filename = $object->files->entity_files[0]['doc_filename'];
								$filepath = Storage::disk($entity->media_disk_files)->url($filename);
								$item->route = null;
								$item->params = null;
								$item->url = $filepath;
								$item->target = '_blank';
							}

							$related[] = $item;
						}
					}

				}

				// Related Entities
				$relatedEntities = $relatedItems->related_entities;
				foreach ($relatedEntities as $rel) {

					$item = new stdClass;

					$object_id = $rel['module_page_menu_id'];

					// get related object
					$object = MenuItem::find($object_id);
					if ($object) {
						$item->title = $object->title;
						$item->route = $object->routename;
						$item->params = null;
						$item->url = null;
						$item->target = '_self';

						$related[] = $item;
					}

				}
			}

			return $related;

		} else {
			return null;
		}

	}

	/**
	 * Get the Lara Entity Class by key
	 *
	 * @param string $resourceSlug
	 * @return mixed|null
	 */
	private function getFrontResourceBySlug(string $resourceSlug)
	{

		$lara = $this->getFrontLaraClass($resourceSlug);

		if ($lara) {
			$entity = new $lara;
		} else {
			$entity = null;
		}

		return $entity;

	}

	/**
	 * Translate entity key to a full Lara Entity class name
	 *
	 * @param string $resourceSlug
	 * @return string
	 */
	private function getFrontLaraClass(string $resourceSlug)
	{

		$laraClass = '\Lara\Common\Lara\\' . ucfirst($resourceSlug) . 'Entity';

		if (!class_exists($laraClass)) {

			$laraClass = '\Eve\Lara\\' . ucfirst($resourceSlug) . 'Entity';

			if (!class_exists($laraClass)) {

				$laraClass = null;

			}

		}

		return $laraClass;

	}

	/**
	 * Get Page Block for Email
	 *
	 * @param string $language
	 * @param string $resourceSlug
	 * @return mixed
	 */
	private function getEmailPageContent(string $language, string $resourceSlug)
	{

		$slug = $resourceSlug . '-email-' . $language;

		$object = Page::langIs($language)
			->where('cgroup', 'email')
			->where('slug', $slug)->first();

		if (empty($object)) {

			$title = ucfirst($resourceSlug) . ' Email Title';

			// get default backend user
			$user = User::where('name', 'admin')->first();

			$object = $this->createNewModulePage($user->id, $language, $title, 'email', $slug);

		}

		return $object;

	}

	/**
	 * Create a specific module page
	 *
	 * @param int $user_id
	 * @param string $language
	 * @param string $title
	 * @param string $cgroup
	 * @param string $slug
	 * @return mixed
	 */
	private function createNewModulePage(int $user_id, string $language, string $title, string $cgroup, string $slug)
	{

		$entity = Entity::where('resource_slug', 'pages')->first();
		$lara = $this->getFrontResourceBySlug($entity->resource_slug);
		$pageEntity = new $lara;

		$data = [
			'title'     => $title,
			'menuroute' => '',
		];

		$data = array_merge($data, ['user_id' => $user_id]);
		$data = array_merge($data, ['language' => $language]);
		$data = array_merge($data, ['slug' => $slug, 'slug_lock' => 1]);

		if ($pageEntity->hasBody()) {
			$data = array_merge($data, ['body' => '']);
		}
		if ($pageEntity->hasLead()) {
			$data = array_merge($data, ['lead' => '']);
		}
		if ($pageEntity->hasGroups()) {
			$data = array_merge($data, ['cgroup' => $cgroup]);
		}
		if ($pageEntity->hasStatus()) {
			$data = array_merge($data, ['publish' => 1, 'publish_from' => Carbon::now()]);
		}

		$newModulePage = Page::create($data);

		return $newModulePage;
	}

	/**
	 * Find special Module Page by their Slug
	 *
	 * Most content entities, other that Pages, are often displayed as lists,
	 * either with or without a master/detail structure.
	 * Well known examples are blogs, team pages, events, etc.
	 *
	 * When a specific index method (!Page) is attached to a frontend menu item,
	 * we automatically attach a special kind of page (called a 'module page') to this menu item.
	 * A 'module page' is technically a Page object with a group value of 'module'.
	 *
	 * This so-called 'module page' can be seen as a 'container' in which the list is displayed.
	 * Think of it as a Wordpress page, with a shortcode to a special plugin in it.
	 *
	 * This module page gives us the following advantages:
	 * - we can add a custom intro (title, text, images, hooks) to the list
	 * - we can assign custom layout to the module page
	 * - we can add seo to the module page
	 *
	 * Because module page are fetched by their unique slugs ('team-index-module-[lang]'),
	 * the slugs are always locked, and cannot be modified by webmasters.
	 *
	 * @param string $language
	 * @param object $entity
	 * @param string $method
	 * @return mixed
	 */
	private function getModulePageBySlug(string $language, object $entity, string $method)
	{

		$modulePageSlug = $entity->getResourceSlug() . '-' . $method . '-module-' . $language;
		$modulePage = Page::langIs($language)->where('cgroup', 'module')->where('slug', $modulePageSlug)->first();
		if (empty($modulePage)) {
			$modulePageTitle = ucfirst($entity->getResourceSlug()) . ' ' . ucfirst($method) . ' Module Page';

			return $this->createNewModulePage(Auth::user()->id, $language, $modulePageTitle, 'module', $modulePageSlug);
		} else {
			return $modulePage;
		}
	}

	/**
	 * Get SEO values for a specific object
	 *
	 * Fallback: default values
	 *
	 * @param object $object
	 * @param object|null $fallback
	 * @return stdClass
	 */
	private function getSeo(object $object, ?object $fallback = null)
	{

		$seo = new stdClass;

		// SEO Title
		if ($object->seo && !empty($object->seo->seo_title)) {
			$seo->seo_title = $object->seo->seo_title;
		} elseif ($fallback && $fallback->seo && !empty($fallback->seo->seo_title)) {
			$seo->seo_title = $fallback->seo->seo_title;
		} else {
			$seo->seo_title = $object->title;
		}

		// SEO Description
		if ($object->seo && !empty($object->seo->seo_description)) {
			$seo->seo_description = $object->seo->seo_description;
		} elseif ($fallback && $fallback->seo && !empty($fallback->seo->seo_description)) {
			$seo->seo_description = $fallback->seo->seo_description;
		} else {
			$seo->seo_description = $this->getDefaultSeoByKey($object->language, 'seo_description');
		}

		// SEO Keywords
		if ($object->seo && !empty($object->seo->seo_keywords)) {
			$seo->seo_keywords = $object->seo->seo_keywords;
		} elseif ($fallback && $fallback->seo && !empty($fallback->seo->seo_keywords)) {
			$seo->seo_keywords = $fallback->seo->seo_keywords;
		} else {
			$seo->seo_keywords = $this->getDefaultSeoByKey($object->language, 'seo_keywords');
		}

		return $seo;

	}

	/**
	 * Get the default SEO value for a specific key
	 *
	 * The default SEO values are set  on the home page
	 *
	 * @param string $language
	 * @param string $key
	 * @return string|null
	 */
	private function getDefaultSeoByKey(string $language, string $key)
	{

		$object = $this->getHomePageObject($language);

		if ($object && isset($object->seo)) {
			$value = $object->seo->$key;
		} else {
			$value = null;
		}

		return $value;

	}

	/**
	 * Get the HomePage
	 *
	 * If the Mainmenu is synced to the Pages,
	 * get it from pages table directly (faster)
	 *
	 * If not, get the page ID from the menu table
	 *
	 * @param string $language
	 * @return object|null
	 */
	private function getHomePageObject(string $language)
	{

		$mainMenuID = $this->getFrontMainMnuId();

		if ($mainMenuID) {

			$home = MenuItem::langIs($language)
				->menuIs($mainMenuID)
				->whereNull('parent_id')
				->first();

			if ($home->object_id) {

				return Page::find($home->object_id);

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
	private function getFrontMainMnuId()
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
	 * Get all the default SEO values
	 *
	 * The default SEO values are set on the home page
	 *
	 * @param string $language
	 * @return stdClass
	 */
	private function getDefaultSeo(string $language)
	{

		$object = $this->getHomePageObject($language);

		$seo = new stdClass;

		if (!empty($object)) {

			if ($object->seo) {
				$seo->seo_title = $object->seo->seo_title;
				$seo->seo_description = $object->seo->seo_description;
				$seo->seo_keywords = $object->seo->seo_keywords;
			} else {
				$seo->seo_title = null;
				$seo->seo_description = null;
				$seo->seo_keywords = null;
			}

		} else {

			$seo->seo_title = null;
			$seo->seo_description = null;
			$seo->seo_keywords = null;

		}

		return $seo;

	}

	/**
	 * Get all the Opengraph data
	 *
	 * @param object $object
	 * @return stdClass
	 */
	private function getOpengraph(object $object)
	{

		// get settings
		$settings = Setting::pluck('value', 'key')->toArray();
		$settngz = json_decode(json_encode($settings), false);

		$og = new stdClass;

		// Title
		if ($object->opengraph && !empty($object->opengraph->og_title)) {
			$og->og_title = $object->opengraph->og_title;
		} else {
			$og->og_title = $object->title;
		}

		// Description
		if (isset($settngz->og_descr_max)) {
			$og->og_descr_max = $settngz->og_descr_max;
		}

		if ($object->opengraph && !empty($object->opengraph->og_description)) {
			$og->og_description = $object->opengraph->og_description;
		} else {
			if ($object->lead != '') {
				$og->og_description = str_limit(strip_tags($object->lead), $og->og_descr_max, '');
			} elseif ($object->body != '') {
				$og->og_description = str_limit(strip_tags($object->body), $og->og_descr_max, '');
			} else {
				$og->og_description = '';
			}
		}

		// Image
		if ($object->hasOpenGraphImage() || $object->hasFeatured()) {
			$width = $settngz->og_image_width ?? 1200;
			$height = $settngz->og_image_height ?? 630;
			if ($object->hasOpenGraphImage()) {
				$og->og_image = glideUrl($object->ogimage->path, $width, $height);
			} else {
				$og->og_image = glideUrl($object->featured()->path, $width, $height);
			}
		} else {
			$og->og_image = null;
		}

		// Type
		if (isset($settngz->og_type)) {
			$og->og_type = $settngz->og_type;
		} else {
			$og->og_type = null;
		}

		// Site name
		if (isset($settngz->og_site_name)) {
			$og->og_site_name = $settngz->og_site_name;
		} else {
			$og->og_site_name = null;
		}

		return $og;

	}

	/**
	 * @param $language
	 * @param $entity
	 * @param FrontActiveRoute $activeroute
	 * @param $object
	 * @param $menuTag
	 * @param $ispreview
	 * @return string|null
	 */
	private function getEntityListUrl($language, $entity, FrontActiveRoute $activeroute, $object, $menuTag, $ispreview): ?string
	{
		if ($ispreview) {
			return null;
		} else {
			if ($menuTag) {
				$node = MenuItem::where('language', $language)
					->where('entity_id', $entity->getEntityId())
					->where('tag_id', $menuTag->id)
					->first();
				if ($node) {
					$url = url($language . '/' . $node->route);
				} else {
					$url = $this->getDefaultEntityListUrl($language, $entity, $activeroute);
				}
			} else {
				$url = $this->getDefaultEntityListUrl($language, $entity, $activeroute);
			}

			return $url;
		}
	}

	private function getDefaultEntityListUrl($language, $entity, FrontActiveRoute $activeroute): string
	{
		$node = MenuItem::where('language', $language)
			->where('entity_id', $entity->getEntityId())
			->whereNull('tag_id')
			->first();

		if ($node) {
			$url = url($language . '/' . $node->route);
		} else {
			$url = route($activeroute->getPrefix() . '.' . $entity->getResourceSlug() . '.index');
		}

		return $url;
	}

	private function isPreview($routename)
	{
		return Str::startsWith($routename, 'content.') || Str::startsWith($routename, 'contenttag.');
	}

}
