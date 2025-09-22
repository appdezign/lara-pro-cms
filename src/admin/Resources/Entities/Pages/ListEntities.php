<?php

namespace Lara\Admin\Resources\Entities\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Resources\Entities\EntityResource;

class ListEntities extends ListRecords
{
    protected static string $resource = EntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
	        CreateAction::make()
		        ->icon('heroicon-s-plus')
		        ->iconButton(),
        ];
    }

}
