<?php

namespace Lara\Admin\Resources\Tags\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;
use Lara\Admin\Resources\Tags\TagResource;
use Lara\Admin\Traits\HasLocks;
use Lara\Admin\Traits\HasTerms;

class EditTag extends EditRecord
{

	use HasTerms;
	use HasLocks;

    protected static string $resource = TagResource::class;

	public function mount(int|string $record): void
	{
		parent::mount($record);
		static::checkRecordLock($this->record);
		static::lockRecord($this->record);
	}


	public function getTitle(): string
    {
        $entity = $this->getRecord();
        return $entity->title;
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
			        return redirect()->route('filament.admin.resources.tags.index');
		        }),
	        Action::make('save')
		        ->label('save')
		        ->color('danger')
		        ->submit(null)
		        ->action(function() {
			        $this->save();
		        }),
        ];
    }

	public function render(): View
	{
		return view($this->getView(), $this->getViewData())
			->layout('lara-admin::layout.focus-mode', [
				'livewire'        => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);
	}

	protected function afterSave(): void
	{
		static::processTagNodes($this->record->language, $this->record->resource_slug, $this->record->taxonomy_id);
	}

}
