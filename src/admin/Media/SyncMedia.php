<?php

namespace Lara\Admin\Media;

use Lara\Admin\Traits\HasMedia;
use Lara\Common\Models\Entity;
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

		// sync attached media
		$images = ObjectImage::all();
		foreach ($images as $image) {
			static::lockMedia($image->media);
		}

		// sync embedded media
		$entities = Entity::whereIn('cgroup', ['page', 'block', 'entity'])->get();
		foreach ($entities as $entity) {
			$model = $entity->model_class;

			$objects = $model::all();
			foreach ($objects as $object) {
				foreach ($media as $item) {
					// check lead
					if (str_contains($object->lead, $item->path)) {
						static::lockMedia($item);
					}

					// check body
					if (str_contains($object->body, $item->path)) {
						static::lockMedia($item);
					}

					// check extra body fields, if any
					$extraBodyFields = $entity->col_extra_body_fields;
					if($extraBodyFields > 0) {
						for($i = 2; $i <= $extraBodyFields + 1; $i++) {
							if (str_contains($object->{"body{$i}"}, $item->path)) {
								static::lockMedia($item);
							}
						}
					}

				}
			}
		}

		return true;
	}

}
