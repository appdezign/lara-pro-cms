<?php

namespace Lara\Admin\Pages\Lara;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

use Illuminate\Contracts\Support\Htmlable;
use Lara\Admin\Resources\Tags\TagResource;
use Lara\Common\Models\Taxonomy;

class LaraListRecords extends ListRecords
{
	public function getTitle(): string | Htmlable
	{
		return _q('lara-app::' . static::$resource::getSlug() . '.entity.title', true);
	}

	protected function getHeaderActions(): array
	{

		$resourceSlug = static::$resource::getSlug();

		$taxonomy = Taxonomy::where('slug', 'category')->first();

		return [

			Action::make('reorder')
				->action(fn() => redirect()->route('filament.admin.resources.'.$resourceSlug.'.reorder', []))
				->icon('heroicon-o-arrows-up-down')
				->iconButton()
				->visible(static::$resource::resourceIsSortable()),

			Action::make('tags')
				->action(function () use ($taxonomy, $resourceSlug) {
					return redirect(TagResource::getUrl('index', ['filters[resource_slug][value]' => $resourceSlug, 'filters[taxonomy_id][value]' => $taxonomy->id]));
				})->icon('heroicon-o-tag')
				->iconButton()
				->visible(static::$resource::resourceHasTerms()),

			CreateAction::make()
				->icon('heroicon-s-plus')
				->iconButton()
			->visible(static::$resource::getEntity()->cgroup != 'form'),
		];
	}
}
