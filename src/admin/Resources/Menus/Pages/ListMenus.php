<?php

namespace Lara\Admin\Resources\Menus\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Concerns\HasLocks;
use Lara\Admin\Resources\Menus\MenuResource;

class ListMenus extends ListRecords
{
    use HasLocks;

    protected static string $resource = MenuResource::class;

    public function mount(): void
    {
        parent::mount();
        static::unlockAbandonedObjects();
    }

    protected function getActions(): array
    {
        return [
            Action::make('backtoindex')
                ->url(route('filament.admin.resources.menu-items.index'))
                ->icon('bi-chevron-left')
                ->iconButton()
                ->color('gray'),

            CreateAction::make()
                ->icon('bi-plus-lg')
                ->iconButton(),
        ];
    }
}
