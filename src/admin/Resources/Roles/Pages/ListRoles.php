<?php

namespace Lara\Admin\Resources\Roles\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Resources\Roles\RoleResource;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
	        CreateAction::make()
		        ->icon('bi-plus-lg')
		        ->iconButton(),
        ];
    }

}
