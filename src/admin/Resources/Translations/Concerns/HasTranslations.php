<?php

namespace Lara\Admin\Resources\Translations\Concerns;

use Illuminate\Support\Facades\File;
use Lara\Common\Models\Translation;

trait HasTranslations
{

	protected static function exportTranslationsToFile(): int
	{

		$modules = config('lara.translations.modules');

		$supportedLocales = array_keys(config('laravellocalization.supportedLocales'));

		$counter = 0;

		foreach ($supportedLocales as $locale) {

			foreach ($modules as $module) {

				$langPath = app()->langPath();

				$vendorPath = $langPath . '/vendor';
				static::checkDirectory($vendorPath);

				$modulePath = $vendorPath . '/' . $module;
				static::checkDirectory($modulePath);

				$localepath = $modulePath . '/' . $locale . '/';
				static::checkDirectory($localepath);

				// create language path
				if (!File::isDirectory($localepath)) {
					File::makeDirectory($localepath);
				}

				if (File::isDirectory($localepath)) {

					// $this->unlockFilesInTranslationDir($localepath);

					File::cleanDirectory($localepath);

					// get groups
					$groups = Translation::distinct()
						->where('module', $module)
						->select('resource')
						->orderBy('resource', 'asc')
						->get();

					foreach ($groups as $group) {

						// get tags
						$tags = Translation::distinct()
							->where('module', $module)
							->where('resource', $group->resource)
							->select('tag')
							->orderBy('tag', 'asc')
							->get();

						$contents = "<?php\n\nreturn [\n";

						foreach ($tags as $tag) {

							$contents .= "\t'" . $tag->tag . "' => [\n";

							$objects = Translation::langIs($locale)
								->where('module', $module)
								->where('resource', $group->resource)
								->where('tag', $tag->tag)
								->orderBy('key', 'asc')
								->select('resource', 'key', 'value')
								->get();

							foreach ($objects as $object) {
								$contents .= "\t\t'" . $object->key . "' => '" . addslashes($object->value) . "',\n";
								$counter++;
							}

							$contents .= "\t],\n";

						}

						$contents .= "];\n";

						// define path
						$path = $localepath . $group->resource . '.php';

						// write to file
						File::put($path, $contents);

					}

					// $this->lockFilesInTranslationDir($localepath);

				}

			}

		}

		return $counter;
	}

	protected static function checkDirectory($path): void
	{
		if (!File::isDirectory($path)) {
			File::makeDirectory($path);
		}
	}

}
