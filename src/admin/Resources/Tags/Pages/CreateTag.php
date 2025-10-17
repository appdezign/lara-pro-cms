<?php

namespace Lara\Admin\Resources\Tags\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Lara\Admin\Resources\Tags\TagResource;
use Lara\Admin\Traits\HasTerms;

class CreateTag extends CreateRecord
{

	use HasTerms;

    protected static string $resource = TagResource::class;

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

	protected function afterCreate(): void
	{
		static::processTagNodes($this->record->language, $this->record->resource_slug, $this->record->taxonomy_id);
	}

}
