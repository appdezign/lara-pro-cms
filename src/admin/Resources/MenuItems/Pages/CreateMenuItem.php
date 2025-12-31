<?php

namespace Lara\Admin\Resources\MenuItems\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;
use Lara\Admin\Resources\MenuItems\Concerns\HasMenu;
use Lara\Admin\Resources\MenuItems\MenuItemResource;

class CreateMenuItem extends CreateRecord
{

	use HasMenu;

    protected static string $resource = MenuItemResource::class;

	public function getFormActions(): array
	{
		return [];
	}

	protected function getHeaderActions(): array
	{
		return [
			Action::make('backtoindex')
				->url(static::getResource()::getUrl())
				->icon('bi-chevron-left')
				->iconButton()
				->color('gray'),
			$this->getCreateFormAction()
				->label(_q('lara-admin::default.action.save'))
				->submit(null)
				->action(fn() => $this->create()),
		];
	}

	protected function mutateFormDataBeforeFill(array $data): array
	{
		return static::mutateMenuFormDataBeforeFill($data);
	}

	protected function mutateFormDataBeforeCreate(array $data): array
	{
		return static::mutateMenuFormDataBeforeSave($data);
	}

	protected function afterCreate(): void
	{
		static::processMenuNodes($this->record->language, $this->record->menu_id);

		// refresh route cache
		session(['routecacheclear' => true]);

	}

	public function render(): View
	{
		return view($this->getView(), $this->getViewData())
			->layout('lara-admin::layout.focus-mode', [
				'livewire' => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);
	}

}
