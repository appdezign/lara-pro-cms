<?php

namespace Lara\Front\Http\Concerns;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Lara\Common\Models\MenuItem;
use Lara\Front\Http\Lara\FrontActiveRoute;

trait HasFrontRoutes
{

	/**
	 * Get the Laravel route name from the given url
	 *
	 * @param string $url
	 * @return mixed
	 */
	private function getRouteFromUrl(string $url)
	{
		// NOTE: v10

		return app('router')->getRoutes()->match(app('request')->create($url))->getName();
	}

	/**
	 * Get a complete Frontent SEO Route for a specific entity list or object
	 *
	 * @param string $resourceSlug
	 * @param string $method
	 * @return string
	 */
	private function getFrontSeoRoute(string $resourceSlug, string $method, bool $single = false)
	{

		if ($resourceSlug == 'pages') {
			$method = 'show';
		}

		$entity = $this->getResourceBySlug($resourceSlug);

		$entityView = $entity->getViews()->where('method', $method)->first();

		if ($entityView) {
			$menuItem = MenuItem::where('entity_id', $entity->getEntityId())
				->where('entity_view_id', $entityView->id)
				->whereNull('tag_id')
				->first();

			if ($menuItem) {
				if ($menuItem->is_home == 1) {
					return 'special.home.show';
				} else {
					return $this->buildRouteName($menuItem->routename, $single);
				}
			}
		}

		if (Route::has('contenttag.' . $resourceSlug . '.' . $method)) {
			return $this->buildRouteName('contenttag.' . $resourceSlug . '.' . $method, $single);
		} else {
			return $this->buildRouteName('content.' . $resourceSlug . '.' . $method, $single);
		}

	}

	private function buildRouteName(string $routename, bool $single = false)
	{
		if($single) {
			return $routename . '.show';
		} else {
			return $routename;
		}
	}

	private function checkFrontRedirect($language, $entity, $activeroute, $object)
	{

		if (empty($object)) {

			// object not found, redirect to list
			return redirect()->route($activeroute->getPrefix() . '.' . $entity->getResourceSlug() . '.index');

		} else {

			// redirect entity objects to their menu url, if possible
			$isPreview = $this->checkEntityRoute($language, $entity, $activeroute, $object);

			// if the page is not a preview, make sure it is published
			if (!$isPreview && ($entity->hasStatus())) {
				if ($object->publish == 0 || (!empty($object->publish_to) && $object->publish_to < Carbon::now()->toDateTimeString())) {
					return redirect()->route($activeroute->getPrefix() . '.' . $entity->getResourceSlug() . '.index');
				}
			}

		}
	}

	/**
	 * Check if a page with a preview route can be redirected to a menu route
	 *
	 * @param string $language
	 * @param object $entity
	 * @param int $id
	 * @return false|Application|RedirectResponse
	 */
	private function checkPageRoute(string $language, object $entity, FrontActiveRoute $activeroute, int $id)
	{

		if ($entity->getResourceSlug() == 'pages' && $activeroute->getPrefix() == 'content') {

			$menuitem = MenuItem::where('type', 'page')
				->where('object_id', $id)
				->first();

			if ($menuitem) {
				return redirect($language . '/' . $menuitem->route)->send();
			} else {
				// this is a preview page, check if user is logged in
				if (Auth::check()) {
					return false;
				} else {
					return redirect(route('error.show.404', '404'))->send();
				}
			}

		} else {
			return false;
		}

	}

	/**
	 * Check if a page with a preview route can be redirected to a menu route
	 *
	 * @param string $language
	 * @param object $entity
	 * @param object $object
	 * @return false|Application|RedirectResponse
	 */
	private function checkEntityRoute(string $language, object $entity, FrontActiveRoute $activeroute, object $object)
	{

		$isPreview = false;

		if ($activeroute->getPrefix() == 'content' || $activeroute->getPrefix() == 'contenttag') {

			if ($object->publish == 1) {

				$menuitem = MenuItem::langIs($language)->where('type', 'entity')
					->where('entity_id', $entity->getEntityId())
					->whereNull('tag_id')
					->first();

				if ($menuitem) {

					$redirectUrl = $language . '/' . $menuitem->route . '/' . $object->slug;

					if ($entity->hasTags()) {
						$redirectUrl = $redirectUrl . '.html';
					}

					redirect($redirectUrl)->send();

				} else {
					// this is a preview page, check if user is logged in
					if (Auth::check()) {
						$isPreview = true;
					} else {
						return redirect(route('error.show.404', '404'))->send();
					}
				}

			} else {
				// this is a preview page, check if user is logged in
				if (Auth::check()) {
					$isPreview = true;
				} else {
					return redirect(route('error.show.404', '404'))->send();
				}
			}

		}

		return $isPreview;

	}

}
