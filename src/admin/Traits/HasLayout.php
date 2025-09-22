<?php

namespace Lara\Admin\Traits;

use Lara\Admin\Enums\LayoutSections;
use Qirolab\Theme\Theme;

trait HasLayout
{

	private static function getFullLayout()
	{

		$layoutPath = Theme::path('views') . '/_layout/_layout.xml';
		$partials = simplexml_load_file($layoutPath);

		$app = app();
		$layout = $app->make('stdClass');

		foreach ($partials as $partial) {

			$partial_key = $partial->key;

			$layout->$partial_key = $app->make('stdClass');

			foreach ($partial->items->item as $item) {

				$item_key = (string)$item->itemKey;

				$layout->$partial_key->$item_key = $app->make('stdClass');

				$layout->$partial_key->$item_key->friendlyName = (string)$item->friendlyName;
				$layout->$partial_key->$item_key->partialFile = (string)$item->partialFile;
				$layout->$partial_key->$item_key->isDefault = (string)$item->isDefault;
			}

		}

		return $layout;

	}

	/**
	 * @return mixed An object containing the default layout values for each section.
	 */
	private static function getDefaultLayoutValues()
	{
		$layout = static::getFullLayout();
		$sections = LayoutSections::toArray();
		$defaultValues = [];
		foreach ($sections as $section) {
			foreach ($layout->$section as $options) {
				$optionValue = $options->partialFile;
				if ($options->isDefault == 'true') {
					$defaultValues[$section] = $optionValue;
				}
			}
		}

		return json_decode(json_encode($defaultValues), false);
	}

	private static function replaceDefaultLayoutValues($record): void
	{
		$layoutDefaults = static::getDefaultLayoutValues();
		$layout = $record->layout;
		if($layout) {
			foreach ($layoutDefaults as $section => $defaultValue) {
				if($layout->$section == $defaultValue) {
					$layout->$section = null;
				}
			}
			$layout->save();
		}
	}
}
