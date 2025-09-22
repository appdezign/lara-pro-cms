<?php

namespace Lara\Admin\Pages\Lara;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;

class LaraViewRecord extends ViewRecord
{
    public function getTitle(): string
    {
        $record = $this->getRecord();
		if(property_exists($record, 'title')) {
			return $record->title;
		} else {
			return parent::getTitle();
		}
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backtoindex')
                ->url(static::getResource()::getUrl())
                ->icon('heroicon-o-chevron-left')
                ->iconButton()
                ->color('gray'),
            EditAction::make()
	        ->visible(static::$resource::getEntity()->cgroup != 'form'),
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
	}
}
