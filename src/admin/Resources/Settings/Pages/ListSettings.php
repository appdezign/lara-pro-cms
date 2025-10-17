<?php

namespace Lara\Admin\Resources\Settings\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Resources\Settings\SettingResource;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
	        CreateAction::make()
		        ->icon('bi-plus-lg')
		        ->iconButton(),
        ];
    }

}
