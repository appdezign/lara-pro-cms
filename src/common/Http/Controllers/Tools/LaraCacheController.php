<?php

namespace Lara\Common\Http\Controllers\Tools;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Spatie\ResponseCache\Facades\ResponseCache;

use Throwable;

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

		$commands = [
			'route_cache'  => 'lara:route:cache',
			'config_cache' => 'config:cache',
			'event_cache'  => 'event:cache',
			'view_cache'   => 'view:cache',
		];

		$cached = [];
		$failed = [];

		foreach ($commands as $type => $command) {
			if ($this->callArtisanCommand($command)) {
				$cached[] = $type;
			} else {
				$failed[] = $type;
			}
		}

		session()->forget('laracacheclear');

		return response()->json([
			'success' => $failed === [],
			'payload' => [
				'laracache' => $cached,
				'failed'    => $failed,
			],
		]);

	}

	/**
	 * Run an Artisan command, logging rather than surfacing any failure.
	 *
	 * Catching \Throwable matters here: the previous `catch (Exception $e)` resolved
	 * against this namespace, so it never matched and the failure escaped uncaught.
	 */
	private function callArtisanCommand(string $command): bool
	{
		try {
			Artisan::call($command);

			return true;
		} catch (Throwable $e) {
			Log::error('lara cache: artisan command failed', [
				'command'   => $command,
				'exception' => $e,
			]);

			return false;
		}
	}

}
