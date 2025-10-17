<?php

namespace Lara\Admin\Resources\MenuItems\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;
use Lara\Admin\Resources\MenuItems\Concerns\HasMenu;
use Lara\Admin\Resources\MenuItems\MenuItemResource;

class EditMenuItem extends EditRecord
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
			Action::make('save')
				->label(_q('lara-admin::default.action.save'))
				->color('danger')
				->submit(null)
				->action('save'),
		];
	}


	protected function mutateFormDataBeforeFill(array $data): array
	{
		return static::mutateMenuFormDataBeforeFill($data);
	}

	protected function mutateFormDataBeforeSave(array $data): array
	{
		return static::mutateMenuFormDataBeforeSave($data);
	}


	protected function afterSave(): void
	{
		static::processMenuNodes($this->record->language, $this->record->menu_id);
		static::checkModulePage($this->record);
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
