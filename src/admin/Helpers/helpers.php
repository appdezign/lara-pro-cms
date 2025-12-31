<?php

use Lara\Common\Models\Translation;
use Lara\Common\Models\Entity;

if (!function_exists('_q')) {

	/**
	 * @param string $fullkey
	 * @param $uppercase
	 * @param $replace
	 * @param $locale
	 * @return string|null
	 */
	function _q(string $fullkey, bool $uppercase = false, array $replace = [], string $locale = null): ?string
	{

		$translation = null;

		if (__($fullkey, $replace, $locale) == $fullkey) {

			if (str_contains($fullkey, '::')) {

				list($module, $langkey) = explode('::', $fullkey);

				$key_array = explode('.', $langkey);

				if (sizeof($key_array) == 3) {

					// no translation found, use last part of key
					list($group, $tag, $key) = explode('.', $langkey);

					$tempkey = '_' . $key;

					if (!empty($key)) {
						addMissingLanguageKey($module, $group, $tag, $key, $tempkey);
					}

					$translation = $tempkey;

				} else {
					dd($fullkey);
				}

			} else {
				dd($fullkey);
			}

		} else {
			// use translation
			$translation = __($fullkey, $replace, $locale);
		}

		if ($uppercase) {
			return ucfirst($translation);
		} else {
			return $translation;
		}

	}
}

if (!function_exists('addMissingLanguageKey')) {

	/**
	 * @param string $module
	 * @param string $resource
	 * @param string $tag
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	function addMissingLanguageKey(string $module, string $resource, string $tag, string $key, string $value): void
	{

		$supportedLocales = array_keys(config('laravellocalization.supportedLocales'));
		foreach ($supportedLocales as $locale) {

			$translation = Translation::langIs($locale)
				->where('module', $module)
				->where('resource', $resource)
				->where('tag', $tag)
				->where('key', $key)
				->first();

			if ($translation === null) {
				Translation::create([
					'language' => $locale,
					'module'   => $module,
					'resource' => $resource,
					'tag'      => $tag,
					'key'      => $key,
					'value'    => $value,
				]);
			}

		}

	}

}

if (!function_exists('getIndexRoutename')) {

	function getIndexRoutename(string $routeName): ?string
	{

		$prefix = 'filament';
		$panelId = 'admin';
		$resourceKey = 'resources';

		// check for resources
		$routeNameParts = explode('.resources.', $routeName);
		if (sizeof($routeNameParts) > 1) {
			$resourcePart = $routeNameParts[1];
			$parts = explode('.', $resourcePart);
			array_pop($parts);
			$resource = implode('.', $parts);

			$hasLanguages = config('lara.has_content_languages');
			$entities = Entity::pluck('resource_slug')->toArray();

			if(in_array($resource, $hasLanguages) || in_array($resource, $entities)) {
				$resourcePath = $prefix . '.' . $panelId . '.' . $resourceKey . '.' . $resource . '.index';
				if (Route::has($resourcePath)) {
					return $resourcePath;
				} else {
					return null;
				}
			}

		} else {

			return null;
		}

		return null;

	}
}

if (!function_exists('chmod_r')) {
	function chmod_r($dir, $dirPermissions, $filePermissions): void
	{
		$dp = opendir($dir);
		while ($file = readdir($dp)) {
			if (($file == ".") || ($file == "..")) {
				continue;
			}

			$fullPath = $dir . "/" . $file;

			if (is_dir($fullPath)) {
				chmod($fullPath, $dirPermissions);
				chmod_r($fullPath, $dirPermissions, $filePermissions);
			} else {
				chmod($fullPath, $filePermissions);
			}

		}
		closedir($dp);
	}
}

