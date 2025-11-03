<?php

namespace Lara\Admin\Resources\Entities\Pages;


use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

use Illuminate\Support\Facades\Auth;

use Lara\Admin\Resources\Entities\Concerns\HasMigrations;
use Lara\Admin\Resources\Entities\EntityResource;

class ListEntities extends ListRecords
{

	use HasMigrations;

    protected static string $resource = EntityResource::class;

    protected function getHeaderActions(): array
    {
        return static::getEntityHeaderActions();
    }

	private static function getEntityHeaderActions() {

		$rows = [];

		if(Auth::user()->hasRole('superadmin')) {

			$rows[] = Action::make('create_migrations')
				->label('Create Migrations')
				->action(function () {
					static::createMigrations();
					return redirect(EntityResource::getUrl());
				})
				->requiresConfirmation()
				->color('danger')
				->modalHeading('Create Migrations');

			$rows[] =  Action::make('create_seeders')
				->label('Create Seeders')
				->action(function () {
					static::createSeeds();
					return redirect(EntityResource::getUrl());
				})
				->requiresConfirmation()
				->color('danger')
				->modalHeading('Create Seeders');
		}

		$rows[] = CreateAction::make()
			->icon('bi-plus-lg')
			->iconButton();

		return $rows;
	}

}
