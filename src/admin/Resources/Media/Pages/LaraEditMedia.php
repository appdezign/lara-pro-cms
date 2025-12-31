<?php

namespace Lara\Admin\Resources\Media\Pages;

use Awcodes\Curator\Resources\Media\Pages\EditMedia;

use Lara\Admin\Traits\HasMedia;

class LaraEditMedia extends EditMedia
{
	use HasMedia;

	public function mount(int | string $record): void
	{
		parent::mount($record);

		static::syncFullMediaLibrary();
	}

}
