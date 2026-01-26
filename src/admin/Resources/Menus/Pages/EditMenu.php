<?php

namespace Lara\Admin\Resources\Menus\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;
use Lara\Admin\Resources\Menus\MenuResource;
use Lara\Admin\Traits\HasLocks;

class EditMenu extends EditRecord
{
	use HasLocks;

    protected static string $resource = MenuResource::class;

	public function mount(int|string $record): void
	{
		parent::mount($record);
		static::checkRecordLock($this->record);
		static::lockRecord($this->record);
	}

	public function getFormActions(): array
	{
		return [];
	}

	protected function getHeaderActions(): array
	{
		return [
			Action::make('unlockrecord')
				->icon('bi-chevron-left')
				->iconButton()
				->color('gray')
				->action(function () {
					static::unlockRecord($this->record);
					return redirect()->route('filament.admin.resources.'.static::getResource()::getSlug().'.index');
				}),
			Action::make('save')
				->label(_q('lara-admin::default.action.save'))
				->color('danger')
				->submit(null)
				->action('save'),
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
