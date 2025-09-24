<?php

namespace Lara\Admin\Resources\Entities\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Lara\Admin\Resources\Entities\Concerns\HasMigrations;
use Lara\Admin\Resources\Entities\EntityResource;

class ListEntities extends ListRecords
{

	use HasMigrations;

    protected static string $resource = EntityResource::class;

    protected function getHeaderActions(): array
    {
        return [
	        Action::make('export_db')
		        ->label(_q('lara-admin::entities.button.export_db'))
		        ->action(function () {

			        static::createMigrations();
			        static::createSeeds();

			        return redirect(EntityResource::getUrl());
		        })
		        ->requiresConfirmation()
		        ->color('danger')
		        ->modalHeading('Export DB'),

	        CreateAction::make()
		        ->icon('heroicon-s-plus')
		        ->iconButton(),
        ];
    }

}
