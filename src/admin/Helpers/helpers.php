<?php

use Illuminate\Support\Facades\Log;

use Lara\Common\Models\Translation;
use Lara\Common\Models\Entity;

if (!function_exists('_q')) {

	/**
	 * Resolve a Lara translation key.
	 *
	 * A key is expected to look like `module::group.tag.key`. When no translation
	 * exists the key is registered for every supported locale and a placeholder is
	 * returned. A malformed key is logged and degrades to a placeholder as well -
	 * a missing label must never take down the page that renders it.
	 *
	 * @param string $fullkey Translation key, e.g. `lara-app::blogs.model.label_single`
	 * @param bool $uppercase Ucfirst the resolved value
	 * @param array<string, mixed> $replace Replacement tokens passed to __()
	 * @param string|null $locale Force a locale instead of the active one
	 */
	function _q(string $fullkey, bool $uppercase = false, array $replace = [], ?string $locale = null): ?string
	{

		if (__($fullkey, $replace, $locale) != $fullkey) {
			// use translation
			$translation = __($fullkey, $replace, $locale);

			return $uppercase ? ucfirst($translation) : $translation;
		}

		$langkey = str_contains($fullkey, '::')
			? explode('::', $fullkey, 2)[1]
			: null;

		$key_array = $langkey === null ? [] : explode('.', $langkey);

		if (sizeof($key_array) != 3) {

			Log::warning('lara translation: malformed key, expected "module::group.tag.key"', [
				'key' => $fullkey,
			]);

			// degrade to the last segment of whatever we were given
			$segments = explode('.', $fullkey);
			$translation = '_' . end($segments);

			return $uppercase ? ucfirst($translation) : $translation;
		}

		// no translation found, use last part of key
		[$module] = explode('::', $fullkey, 2);
		[$group, $tag, $key] = $key_array;

		$translation = '_' . $key;

		if (!empty($key)) {
			addMissingLanguageKey($module, $group, $tag, $key, $translation);
		}

		return $uppercase ? ucfirst($translation) : $translation;

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

