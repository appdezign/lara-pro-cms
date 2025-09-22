<?php

namespace Lara\Admin\Traits;

use Illuminate\Support\Facades\File;

trait HasCache
{

	public static function clearCache(): void
	{

		File::cleanDirectory(storage_path('framework/cache/data'));
		File::delete(base_path('bootstrap/cache/config.php'));
		File::cleanDirectory(storage_path('framework/views'));
		File::cleanDirectory(storage_path('httpcache'));
		File::cleanDirectory(storage_path('imgcache'));

	}

}
