<?php

namespace Lara\Front\Http\Controllers\Api\Base;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;

use Lara\Front\Http\Concerns\HasFrontEntity;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use LaravelLocalization;

use ReflectionClass;
use ReflectionException;

class BaseApiController extends Controller
{

	use HasFrontEntity;

	/**
	 * @var string
	 */
	protected $modelClass;

	/**
	 * @var string|null
	 */
	protected $routename;

	/**
	 * @var object
	 */
	protected $entity;

	/**
	 * @var string
	 */
	protected $language;

	/**
	 * @var array
	 */
	protected $columns;

	public function __construct()
	{

		// get model class from child controller
		$this->modelClass = $this->determineModelClass();

		$this->language = LaravelLocalization::getCurrentLocale();

		if (!App::runningInConsole()) {

			// get route name
			$this->routename = Route::current()->getName();

			// get entity
			$this->entity = $this->getFrontEntity($this->routename);

		}

		// default fields
		$this->columns = config('lara-front.lara_api_default_columns');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{

		if ($request->has('limit')) {
			$limit = $request->limit;
		} else {
			$limit = config('lara-front.lara_api_object_limit');
		}

		// add standard fields to the default fields
		$this->columns[] = 'slug';
		if ($this->entity->hasLead()) {
			$this->columns[] = 'lead';
		}
		if ($this->entity->hasBody()) {
			$this->columns[] = 'body';
		}

		// add custom fields to the default fields
		foreach ($this->entity->getCustomColumns() as $field) {
			$this->columns[] = $field->field_name;
		}

		$collection = new $this->modelClass;

		$collection = $collection->langIs($this->language);
		$collection = $collection->isPublished();

		if ($this->entity->getResourceSlug() == 'page') {
			$collection = $collection->where('cgroup', 'page');
		}

		$collection = $collection->orderBy($this->entity->getPrimarySortField(), $this->entity->getPrimarySortOrder());
		$collection = $collection->limit($limit);

		$objects = $collection->get($this->columns);

		foreach ($objects as $object) {

			// add seo
			$object->seo_title = $object->seo->seo_title;
			$object->seo_description = $object->seo->seo_description;
			$object->seo_keywords = $object->seo->seo_keywords;
			unset($object->seo);

			// add featured image
			if ($object->hasFeatured()) {
				$object->image = glideUrl($object->featured()->path, 1280, 960);
			} else {
				$object->image = null;
			}
			// add all images
			if ($object->gallery()->count()) {
				$gallery = array();
				foreach ($object->gallery as $img) {
					$gallery[] = glideUrl($img->path, 1280, 960);
				}
				$object->images = $gallery;
			} else {
				$object->images = null;
			}
			unset($object->media);
		}

		return response()->json($objects);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Request $request
	 * @param string|int|null $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id = null)
	{

		$getFullImages = false;
		if ($request->has('image')) {
			$image = $request->get('image');
			if ($image == 'full') {
				$getFullImages = true;
			}
		}

		$getMedia = false;
		if ($request->has('images')) {
			$media = $request->get('media');
			if ($media == 'true') {
				$getMedia = true;
			}
		}

		$getFiles = false;
		if ($request->has('files')) {
			$files = $request->get('files');
			if ($files == 'true') {
				$getFiles = true;
			}
		}

		// add standard fields to the default fields
		$this->columns[] = 'slug';
		if ($this->entity->hasLead()) {
			$this->columns[] = 'lead';
		}
		if ($this->entity->hasBody()) {
			$this->columns[] = 'body';
		}

		// add custom fields to the default fields
		foreach ($this->entity->getCustomColumns() as $field) {
			$this->columns[] = $field->field_name;
		}

		if (is_numeric($id)) {
			$object = $this->modelClass::select($this->columns)->find($id);
		} else {
			$object = $this->modelClass::select($this->columns)->where('slug', $id)->first();
		}

		if ($object) {

			// add seo
			if ($seo) {
				$object->seo_title = $seo->seo_title;
				$object->seo_description = $seo->seo_description;
				$object->seo_keywords = $seo->seo_keywords;
			} else {
				$object->seo_title = null;
				$object->seo_description = null;
				$object->seo_keywords = null;
			}
			unset($object->seo);

			// add featured image
			if ($object->hasFeatured()) {

				if ($getFullImages) {
					$object->image = glideUrl($img->filename, 1920, 1440);
				} else {
					$object->image = glideUrl($img->filename, 1280, 960);
				}
			} else {
				$object->image = null;
			}

			// add all images
			if ($object->gallery()->count()) {
				$gallery = array();
				foreach ($object->fallery as $img) {
					if ($getFullImages) {
						$imagePath = glideUrl($img->filename, 1920, 1440);
					} else {
						$imagePath = glideUrl($img->filename, 1280, 960);
					}
					$gallery[] = $imagePath;
					$img->image_url = $imagePath;
				}
				$object->images = $gallery;
			} else {
				$object->images = null;
			}
			if (!$getMedia) {
				unset($object->media);
			}

			// files
			if ($object->files()->count()) {
				$files = array();
				foreach ($object->files as $file) {
					$filePath = url('assets/media/' . $this->entity->getResourceSlug() . '/' . $file->filename);
					$files[] = $filePath;
					$file->file_url = $filePath;
				}
				$object->attachments = $files;
			} else {
				$object->attachments = null;
			}
			if (!$getFiles) {
				unset($object->files);
			}

		}

		return response()->json($object);

	}

	/**
	 * Determine the model class name of the child controller
	 *
	 * @return string
	 * @throws ReflectionException
	 */
	protected function determineModelClass(): string
	{
		return (new ReflectionClass($this))
			->getMethod('make')
			->getReturnType()
			->getName();
	}

}
