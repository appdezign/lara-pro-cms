<?php

namespace Lara\Admin\Media;

use Lara\Admin\Traits\HasMedia;
use Lara\Common\Models\ObjectImage;

use Awcodes\Curator\Models\Media;

class SyncMedia
{

	use HasMedia;

	public function __invoke(): bool
	{

		// reset
		$media = Media::all();
		foreach ($media as $item) {
			static::unlockMedia($item);
		}

		// sync
		$images = ObjectImage::all();
		foreach ($images as $image) {
			static::lockMedia($image->media);
		}

		return true;
	}

}
