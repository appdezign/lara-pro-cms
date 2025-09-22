<?php

namespace Lara\Admin\Resources\Menus\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;
use Lara\Admin\Resources\Menus\MenuResource;

class CreateMenu extends CreateRecord
{
    protected static string $resource = MenuResource::class;

	public function getFormActions(): array
	{
		return [];
	}

	protected function getHeaderActions(): array
	{
		return [
			Action::make('backtoindex')
				->url(static::getResource()::getUrl())
				->icon('heroicon-o-chevron-left')
				->iconButton()
				->color('gray'),
			$this->getCreateFormAction()
				->label(_q('lara-admin::default.action.save'))
				->submit(null)
				->action(fn() => $this->create()),
		];
	}

	public function render(): View
	{
		return view($this->getView(), $this->getViewData())
			->layout('lara-admin::layout.focus-mode', [
				'livewire' => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);
		return view();
	}
}
