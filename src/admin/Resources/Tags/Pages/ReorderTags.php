<?php

namespace Lara\Admin\Resources\Tags\Pages;

use Filament\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Resources\Pages\Page;
use Lara\Admin\Resources\Tags\TagResource;

class ReorderTags extends Page
{

	protected static string $resource = TagResource::class;

	protected string $view = 'lara-admin::pages.tag-reorder';

	protected function getHeaderActions(): array
	{
		return [
			Action::make('done')
				->label(_q('lara-admin::default.button.done'))
				->action(function () {
					return redirect(TagResource::getUrl());
				}),
		];
	}

	public function render(): View
	{
		return view($this->getView(), $this->getViewData())
			->layout($this->getLayout(), [
				'livewire' => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);
	}
}
