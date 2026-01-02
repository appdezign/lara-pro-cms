<?php

namespace Lara\Common\Http\Controllers\Tools;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class RoutecacheController extends Controller {

	public function __construct() {

	}

	/**
	 * Flush the route cache
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function clear(Request $request) {

		$files = [
			base_path('bootstrap/cache/routes-v7.php')
		];

		$supportedLocales = array_keys(config('laravellocalization.supportedLocales'));
		foreach ($supportedLocales as $locale) {
			$files[] = base_path('bootstrap/cache/routes-v7_'.$locale.'.php');
		}

		// delete cached route files
		$exitcode = File::delete($files);

		session()->forget('routecacheclear');

		return response()->json([
			'success' => true,
			'payload' => [
				'routecache' => 'cleared',
				'exitcode' => $exitcode,
			],
		]);

	}

	public function cache(Request $request) {

		Artisan::call('route:trans:cache');
		Artisan::call('config:cache');

		session()->forget('routecacheclear');

		return response()->json([
			'success' => true,
			'payload' => [
				'routecache' => 'cached',
				'exitcode' => true,
			],
		]);

	}

}
