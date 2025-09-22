<?php

namespace Lara\Admin\Resources\Tags\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;
use Lara\Admin\Resources\Tags\TagResource;
use Lara\Admin\Traits\HasTerms;

class EditTag extends EditRecord
{

	use HasTerms;

    protected static string $resource = TagResource::class;

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
            Action::make('backtoindex')
                ->url(static::getResource()::getUrl())
                ->icon('heroicon-o-chevron-left')
                ->iconButton()
                ->color('gray'),
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
