<?php

namespace Lara\Common\Database\Factories\Concerns;

use Carbon\Carbon;
use Lara\Common\Models\Entity;
use Lara\Common\Models\User;

use Exception;

trait HasLaraFactory
{

	/**
	 * @param $resourceSlug
	 * @return array
	 * @throws Exception
	 */
	private function generateContent($resourceSlug): array
	{

		// get locale
		$locale = config('app.locale');

		// get admin id
		$adminId = $this->getAdminId();
		if (empty($adminId)) {
			throw new Exception('No admin user found');
		}

		// get resource
		$entity = $this->getEntityByResourceSlug($resourceSlug);
		if (empty($entity)) {
			throw new Exception('No resource entity found');
		}


		$content = [
			'user_id'      => $adminId,
			'language'     => $locale,
			'title'        => $this->faker->sentence(5),
			'publish'      => 1,
			'publish_from' => Carbon::now(),
		];

		// lead
		if($entity->col_has_lead) {
			$content['lead'] = $this->faker->paragraph(1);
		}

		// body
		if($entity->col_has_body) {
			$content['body'] = $this->faker->paragraph(4);
		}

		// add custom fields
		$fullTextTypes = ['text', 'textarea', 'richeditor', 'richeditormin'];

		foreach ($entity->customfields as $customfield) {

			if (in_array($customfield->field_type, $fullTextTypes)) {
				$content[$customfield->field_name] = $this->faker->paragraph(1);
			}
			if ($customfield->field_type == 'string') {
				$content[$customfield->field_name] = $this->faker->sentence(3);
			}
			if ($customfield->field_type == 'email') {
				$content[$customfield->field_name] = $this->faker->email();
			}
			if ($customfield->field_type == 'number') {
				$content[$customfield->field_name] = $this->faker->randomNumber(3, false);
			}
			if ($customfield->field_type == 'date') {
				$content[$customfield->field_name] = $this->faker->date();
			}
			if ($customfield->field_type == 'time') {
				$content[$customfield->field_name] = $this->faker->time();
			}
			if ($customfield->field_type == 'datetime') {
				$content[$customfield->field_name] = $this->faker->datetime();
			}

			// exlude menuroute for pages
			if($resourceSlug == 'pages' && $customfield->field_name == 'menuroute') {
				$content[$customfield->field_name] = null;
			}

		}


		return $content;
	}

	private function getAdminId(): ?int
	{

		$userId = User::role('superadmin')->value('id');
		if (empty($userId)) {
			$userId = User::role('admin')->value('id');
			if (empty($userId)) {
				$userId = null;
			}
		}

		return $userId;
	}

	private function getEntityByResourceSlug($resourceSlug): ?Entity
	{
		return Entity::where('resource_slug', $resourceSlug)->first();
	}

}