<?php

namespace Lara\Admin\Resources\Entities\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;
use Lara\Admin\Resources\Entities\EntityResource;

use Lara\Admin\Traits\HasLaraBuilder;

class EditEntity extends EditRecord
{

	use HasLaraBuilder;

    protected static string $resource = EntityResource::class;

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
                ->icon('bi-chevron-left')
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

	protected function mutateFormDataBeforeSave(array $data): array
	{
		if (array_key_exists('sort_is_sortable', $data)) {
			if ($data['sort_is_sortable'] === true) {
				$this->record->sort_primary_field = 'position';
				$this->record->sort_primary_order = 'asc';
			}
		}
		return $data;
	}

	protected function afterSave(): void
	{
		$this->checkExtraDatabaseColumns($this->record);

		// refresh route cache
		session()->push('laracacheclear', ['http_cache', 'route_cache']);

	}

	public function render(): View
	{
		return view($this->getView(), $this->getViewData())
			->layout('lara-admin::layout.entity-focus-mode', [
				'livewire'        => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);
	}


}
