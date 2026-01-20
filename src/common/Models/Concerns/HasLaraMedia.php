<?php
namespace Lara\Common\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

use Lara\Common\Models\ObjectImage;
trait HasLaraMedia {


	public function images(): MorphMany
	{
		return $this->morphMany(ObjectImage::class, 'mediable')->orderBy('order');
	}

	public function featured()
	{
		$img = $this->images()->where('type', 'featured')->with('media')->first();
		return $img?->media;
	}

	public function hasFeatured(): bool
	{
		return !empty($this->featured());
	}

	public function thumb()
	{
		$thumb = $this->images()->where('type', 'thumb')->with('media')->first();
		if($thumb) {
			return $thumb->media;
		} else {
			// fallback to featured
			return $this->featured();
		}
	}

	public function hasThumb(): bool
	{
		return !empty($this->thumb());
	}

	public function hero()
	{
		$img = $this->images()->where('type', 'hero')->with('media')->first();
		return $img?->media;
	}

	public function hasHero(): bool
	{
		return !empty($this->hero());
	}

	public function icon()
	{
		$img = $this->images()->where('type', 'icon')->with('media')->first();
		return $img?->media;
	}

	public function hasIcon(): bool
	{
		return !empty($this->icon());
	}

	public function gallery()
	{
		$collection = collect();
		$gallery = $this->images()->where('type', 'gallery')->with('media')->get();
		foreach($gallery as $img) {
			$collection->add($img->media);
		}
		return $collection;
	}

	public function hasGallery(): bool
	{
		return $this->gallery()->isNotEmpty();
	}

	public function hasImages(): bool
	{
		return $this->images()->count() > 0;
	}

	public function getFile(): ?\stdClass
	{
		// get a single file
		return $this->getMediaRepeaterData($this->files, 'entity_files', 'doc', true);
	}

	public function getFiles(): ?array
	{
		// get an array of files
		return $this->getMediaRepeaterData($this->files, 'entity_files', 'doc');
	}

	public function hasFiles(): bool
	{
		return isset($this->files) && !empty($this->files->entity_files);
	}

	public function getVideoFile(): ?\stdClass
	{
		// get single video file
		return $this->getMediaRepeaterData($this->videofiles, 'entity_videofiles', 'videofile', true);
	}

	public function getVideoFiles(): ?array
	{
		// get array of video files
		return $this->getMediaRepeaterData($this->videofiles, 'entity_videofiles', 'videofile');
	}

	public function hasVideoFiles(): bool
	{
		return isset($this->videofiles) && !empty($this->videofiles->entity_videofiles);
	}

	public function getVideo(): ?\stdClass
	{
		// get single video
		return $this->getMediaRepeaterData($this->videos, 'entity_videos', 'video', true);
	}

	public function getVideos()
	{
		// get array of videos
		return $this->getMediaRepeaterData($this->videos, 'entity_videos', 'video');
	}

	public function hasVideos(): bool
	{
		return isset($this->videos) && !empty($this->videos->entity_videos);
	}

	private function getMediaRepeaterData($data, string $column, ?string $prefix = null, bool $single = false)
	{

		if ($data && $data->$column) {
			$array = array();
			foreach ($data->$column as $item) {
				$object = new \stdClass();
				foreach ($item as $key => $value) {
					if ($prefix) {
						$newKey = Str::replaceStart($prefix . '_', '', $key);
						$object->$newKey = $value;
					} else {
						$object->$key = $value;
					}
				}
				if (property_exists($object, 'filename')) {
					$filename = $object->filename;
					$parts = explode('/', $filename);
					if (sizeof($parts) == 2) {
						$object->filedir = $parts[0];
						$object->filename = $parts[1];
					} else {
						$object->filedir = null;
						$object->filename = $filename;
					}
				}
				$array[] = $object;
			}
			if ($single) {
				return $array[0];
			} else {
				return $array;
			}
		} else {
			return null;
		}
	}
}