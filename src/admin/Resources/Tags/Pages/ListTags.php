<?php

namespace Lara\Admin\Resources\Tags\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Lara\Admin\Resources\Tags\TagResource;
use Lara\Admin\Traits\HasFilters;
use Lara\Admin\Traits\HasLocks;

class ListTags extends ListRecords
{

	use HasFilters;
	use HasLocks;

	protected static string $resource = TagResource::class;

	protected static ?string $resourceRoute = null;

	public function mount(): void
	{
		parent::mount();
		static::unlockAbandonedObjects();
	}

	protected function getHeaderActions(): array
	{

		static::$resourceRoute = static::getResourceSlugFromRequest();

		return static::getTagHeaderActions();
	}

	private function getTagHeaderActions(): array
	{
		$actions = array();
		if (static::$resourceRoute) {
			$actions[] = Action::make('backtoindex')
				->url(route(static::$resourceRoute))
				->icon('bi-chevron-left')
				->iconButton()
				->color('gray');

		}
		$actions[] = Action::make('reorder')
			->action(fn() => redirect()->route('filament.admin.resources.tags.reorder', []))
			->icon('bi-arrows-move')
			->iconButton();
		$actions[] = CreateAction::make()
			->icon('bi-plus-lg')
			->iconButton();
		return $actions;
	}

	private function getResourceSlugFromRequest(): ?string {
		$resourceRoute = null;

		// check request first
		if(request()->has('tableFilters')) {
			$tableFilters = request('tableFilters');
			if (is_array($tableFilters) && key_exists('resource_slug', $tableFilters)) {
				$values = $tableFilters['resource_slug'];
				if (key_exists('value', $values)) {
					$resourceSlug = $values['value'];
					$route = 'filament.admin.resources.' . $resourceSlug . '.index';
					if (Route::has($route)) {
						$resourceRoute = $route;
					}
				}
			}
		}

		// check session
		if(empty($resourceRoute)) {
			$resourceSlug = static::getActiveFilterFromPage(ListTags::class, 'resource_slug');
			if($resourceSlug) {
				$route = 'filament.admin.resources.' . $resourceSlug . '.index';
				if (Route::has($route)) {
					$resourceRoute = $route;
				}
			}
		}

		return $resourceRoute;
	}

	public function render(): View
	{
		return view($this->getView(), $this->getViewData())
			->layout('lara-admin::layout.tag-item-list', [
				'livewire'        => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);

		return view();
	}

}
