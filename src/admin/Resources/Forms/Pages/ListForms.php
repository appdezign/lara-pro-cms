<?php

namespace Lara\Admin\Resources\Forms\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Resources\Forms\FormResource;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
	        CreateAction::make()
		        ->icon('bi-plus-lg')
		        ->iconButton(),
        ];
    }

}
