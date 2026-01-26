<?php

namespace Lara\Admin\Resources\Users\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Lara\Admin\Resources\Users\UserResource;

class UsersTable
{
	private static function rs(): UserResource
	{
		$class = UserResource::class;
		return new $class;
	}

	public static function configure(Table $table): Table
	{
		return $table
			->columns([
				TextColumn::make('id')
					->sortable()
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.id')),
				TextColumn::make('name')
					->sortable()
					->searchable()
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.name')),
				TextColumn::make('email')
					->sortable()
					->searchable()
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.email')),
				TextColumn::make('roles')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.roles'))
					->getStateUsing(fn($record) => static::getUserRoles($record)),
			])
			->filters([])
			->actions([
				EditAction::make()
					->label('')
					->tableIcon(fn($record) => $record->isLocked() ? 'bi-lock' : 'bi-pencil-square')
					->disabled(fn($record) => $record->isLocked()),
				DeleteAction::make()
					->label('')
					->tableIcon(fn($record) => $record->isLocked() ? 'bi-lock' : 'bi-trash3')
					->disabled(fn($record) => $record->isLocked()),
			])
			->bulkActions([]);
	}

	private static function getUserRoles($record)
	{
		$roles_str = '';
		$counter = 1;
		foreach ($record->roles as $role) {
			$roles_str .= $role->name;
			if ($counter < $record->roles()->count()) {
				$roles_str .= ', ';
			}
			$counter++;
		}

		return $roles_str;
	}

}
