<?php

namespace Lara\Admin\Livewire;

use Filament\Notifications\Notification;
use Livewire\Component;

use Lara\Admin\Traits\HasCache;

class ClearCache extends Component
{

	use HasCache;

	public function clear(): void
	{

		static::clearCache();

		Notification::make()
			->title(_q('lara-admin::cache.message.cache_cleared'))
			->success()
			->send();

	}

	public function render()
	{
		return view('lara-admin::livewire.clear-cache');
	}
}
