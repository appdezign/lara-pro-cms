<?php

namespace Lara\Admin\Resources\Menus\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;

use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Resources\Menus\MenuResource;

class ListMenus extends ListRecords
{
    protected static string $resource = MenuResource::class;

    protected function getActions(): array
    {
        return [
	        Action::make('backtoindex')
		        ->url(route('filament.admin.resources.menu-items.index'))
		        ->icon('heroicon-o-chevron-left')
		        ->iconButton()
		        ->color('gray'),

	        CreateAction::make()
		        ->icon('heroicon-s-plus')
		        ->iconButton(),
        ];
    }
}
