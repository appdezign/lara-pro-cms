<?php

namespace Lara\Admin\Resources\Tags\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Lara\Admin\Resources\Tags\TagResource;

class CreateTag extends CreateRecord
{
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
                ->icon('heroicon-o-chevron-left')
                ->iconButton()
                ->color('gray'),
            $this->getCreateFormAction()
                ->label(_q('lara-admin::default.action.save'))
                ->submit(null)
                ->action(fn() => $this->create()),
        ];
    }

}
