<?php

namespace Lara\Admin\Resources\Roles\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Lara\Admin\Resources\Roles\RoleResource;
use Spatie\Permission\Models\Role;

class RolesTable
{
	private static function rs(): RoleResource
	{
		$class = RoleResource::class;
		return new $class;
	}

	public static function configure(Table $table): Table
	{
		return $table
			->columns([
				TextColumn::make('name')
					->sortable()
					->searchable()
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.name')),
				TextColumn::make('guard_name')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.guard')),

			])
			->filters([])
			->actions([
				EditAction::make()
					->label(''),
				DeleteAction::make()
					->label('')
					->disabled(fn(Role $record) => $record->users()->count() > 0),
			])
			->bulkActions([]);
	}

}
