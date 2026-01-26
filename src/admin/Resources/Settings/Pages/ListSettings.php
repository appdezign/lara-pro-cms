<?php

namespace Lara\Admin\Resources\Settings\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Resources\Settings\SettingResource;
use Lara\Admin\Traits\HasLocks;

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
