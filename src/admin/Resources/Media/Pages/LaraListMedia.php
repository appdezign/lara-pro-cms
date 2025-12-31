<?php

declare(strict_types=1);

namespace Lara\Admin\Resources\Media\Pages;

use Awcodes\Curator\Resources\Media\Pages\ListMedia;
use Lara\Admin\Traits\HasMedia;

class LaraListMedia extends ListMedia
{

	use HasMedia;

    public function mount(): void
    {
        parent::mount();

		static::syncFullMediaLibrary();

    }

}
