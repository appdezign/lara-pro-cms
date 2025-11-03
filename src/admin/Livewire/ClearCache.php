<?php

namespace Lara\Admin\Livewire;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

use Lara\Admin\Traits\HasCache;

class ClearCache extends Component implements HasSchemas
{
	use InteractsWithSchemas;
	use HasCache;

	public ?array $data = [];

	public function mount(): void
	{
		$this->form->fill();
	}

	public function form(Schema $schema): Schema
	{
		return $schema
			->components([
				CheckboxList::make('cache_types')
					->label(_q('lara-admin::cache.column.cache_types', true))
					->options([
						'app_cache'    => 'Application cache',
						'config_cache' => 'Config cache',
						'view_cache'   => 'View cache',
						'http_cache'   => 'Http cache',
						'image_cache'  => 'Image cache',
						'route_cache'  => 'Route cache',
					])
					->bulkToggleable()
					->afterStateHydrated(function ($component, $state) {
						if (!filled($state)) {
							$component->state(['app_cache','config_cache', 'view_cache', 'http_cache', 'image_cache', 'route_cache']);
						}
					}),
			])
			->statePath('data');
	}

	public function clear(): void
	{

		$state = $this->form->getState();
		$types = $state['cache_types'];
		$result = static::clearCacheTypes($types, false);

		if($result) {
			Notification::make()
				->title(_q('lara-admin::cache.message.cache_cleared'))
				->success()
				->send();
		} else {
			Notification::make()
				->title(_q('lara-admin::cache.message.select_cache_types_first'))
				->warning()
				->send();
		}


	}

	public function render(): View
	{
		return view('lara-admin::livewire.clear-cache');
	}
}
