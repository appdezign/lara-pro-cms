<?php

namespace Lara\Admin\Resources\Users\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Resources\Users\UserResource;
use Lara\Admin\Traits\HasLocks;

class ListUsers extends ListRecords
{

	use HasLocks;

    protected static string $resource = UserResource::class;

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
