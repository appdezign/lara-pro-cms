<?php

namespace Lara\Common\Http\Controllers\Tools;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

use Spatie\ResponseCache\Facades\ResponseCache;

class LaraCacheController extends Controller
{

	public function clear(Request $request): JsonResponse
	{

		$types = session('laracacheclear');

		if ($types) {

			if (in_array('app_cache', $types)) {
				File::cleanDirectory(storage_path('framework/cache/data'));
			}

			if (in_array('config_cache', $types)) {
				File::delete(base_path('bootstrap/cache/config.php'));
			}

			if (in_array('view_cache', $types)) {
				File::cleanDirectory(storage_path('framework/views'));
			}

			if (in_array('response_cache', $types)) {
				ResponseCache::clear();
			}

			// the route cache is deliberately not cleared here: deleting the cached
			// route files while other requests are booting makes them fatal on the
			// deferred require in RouteServiceProvider::loadCachedRoutes().
			// lara:route:cache (see cache() below) replaces the files atomically instead.
		}

		session()->forget('laracacheclear');

		return response()->json([
			'success' => true,
			'payload' => [
				'laracache' => $types,
			],
		]);

	}

	public function cache(Request $request): JsonResponse
	{

		$this->callArtisanCommand('lara:route:cache');
		$this->callArtisanCommand('config:cache');
		$this->callArtisanCommand('event:cache');
		$this->callArtisanCommand('view:cache');

		session()->forget('laracacheclear');

		return response()->json([
			'success' => true,
			'payload' => [
				'laracache' => [
					'config_cache',
					'event_cache',
					'view_cache',
					'route_cache',
				],
			],
		]);

	}

	private function callArtisanCommand($command): void
	{
		try {
			Artisan::call($command);
		} catch (Exception $e) {
			dd($e);
		}
	}

}
