<?php

namespace Lara\Admin\Resources\Settings\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Concerns\HasLocks;
use Lara\Admin\Resources\Settings\SettingResource;

class ListSettings extends ListRecords
{
    use HasLocks;

    protected static string $resource = SettingResource::class;

    public function mount(): void
    {
        parent::mount();
        static::unlockAbandonedObjects();
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('bi-plus-lg')
                ->iconButton(),
        ];
    }
}
