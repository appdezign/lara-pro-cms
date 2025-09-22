<?php

namespace Lara\Front\Http\Controllers\Special;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontEntity;

use Lara\Common\Models\Upload;
use Lara\Common\Models\User;

use LaravelLocalization;

class UploadController extends Controller
{

	use hasFrontend;
	use HasFrontEntity;

	public function __construct()
	{
		//
	}

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function process(Request $request, $filetype)
	{

		$resourceSlug = $request->get('resource_slug');
		$laraClass = $this->getResourceBySlug($resourceSlug);
		$laraEntity = new $laraClass;
		$entityType = $laraEntity->getEntityModelClass();

		$objectId = $request->get('object_id');
		$mimetype = $request->file('fileuploads')->getMimeType();

		$token = $request->get('_token');
		$dzSessionId = $request->get('dz_session_id');

		if (Auth::check()) {

			// remove previous upload attempts
			DB::table(config('lara-common.database.sys.uploads'))
				->where('user_id', Auth::user()->id)
				->where('entity_type', $entityType)
				->where('object_id', $objectId)
				->where('token', $token)
				->where('dz_session_id', '!=', $dzSessionId)
				->delete();

			// cleanup filename
			$originalMediaName = $request->file('fileuploads')->getClientOriginalName();
			$mediaExtension = $request->file('fileuploads')->getClientOriginalExtension();
			$mediaName = pathinfo($originalMediaName, PATHINFO_FILENAME);
			$cleanMediaName = str_slug($mediaName);

			$timestamp = date('YmdHis');
			$newMediaName = $timestamp . '-' . $cleanMediaName . '.' . $mediaExtension;

			Upload::create([
				'user_id'       => Auth::user()->id,
				'entity_type'   => $entityType,
				'object_id'     => $objectId,
				'token'         => $token,
				'dz_session_id' => $dzSessionId,
				'filename'      => $newMediaName,
				'filetype'      => $filetype,
				'mimetype'      => $mimetype,
			]);

			// move file to temp folder
			$storageDisk = Storage::disk('public');

			$request->file('fileuploads')->storeAs(
				'_temp',
				$newMediaName,
				$storageDisk
			);

			return \Response::json('success', 200);

		} else {

			return \Response::json('error', 500);

		}

	}

}
