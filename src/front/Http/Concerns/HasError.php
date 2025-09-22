<?php

namespace Lara\Front\Http\Concerns;

use Lara\Common\Models\Entity;
use Lara\Common\Models\Page;
use Lara\Common\Models\User;

trait HasError
{

	/**
	 * @param $routename
	 * @return false|string
	 */
	private function getErrorIdFromRoutename($routename)
	{
		$parts = explode('.', $routename);

		return end($parts);
	}

	/**
	 * @param string $errorId
	 * @param string $language
	 * @return Page
	 */
	private function findOrCreateErrorPage(string $errorId, string $language)
	{
		$slug = (config('lara.is_multi_language')) ? $errorId . '-' . $language : $errorId;

		$page = Page::langIs($language)
			->where('slug', $slug)
			->first();

		if ($page) {
			return $page;
		} else {

			// create error page
			$user = User::where('name', 'admin')->first();
			if ($user) {
				$data = [
					'user_id'  => $user->id,
					'language' => $language,
					'title'    => _q('lara-front::error.message.title', true),
					'slug'     => $slug,
					'body'     => _q('lara-front::error.message.body', true),
					'cgroup'   => 'page',
				];
				$entity = Entity::where('resource_slug', 'pages')->first();
				if($entity->col_has_lead == 1) {
					$data['lead'] = '';
				}

				return Page::create($data);

			} else {
				dd('Oops');
			}

		}
	}
}