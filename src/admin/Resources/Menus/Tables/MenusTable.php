<?php

namespace Lara\Admin\Resources\Menus\Tables;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Lara\Admin\Resources\Menus\MenuResource;
use Lara\Common\Models\Menu;

trait MenusTable
{
	private static function rs(): MenuResource
	{
		$class = MenuResource::class;
		return new $class;
	}

	private static function getMenuTableColumns(): array
	{

		$columns = array();

		$columns[] = TextColumn::make('id')
			->width('10%')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.id'))
			->sortable();

		$columns[] = TextColumn::make('title')
			->width('20%')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title'))
			->sortable()
			->searchable();
		$columns[] = TextColumn::make('slug')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.slug'));

		return $columns;

	}

	private static function getMenuTableActions(): array
	{
		$actions = array();

		$actions[] = Action::make('configure_menu')
			->label('')
			->icon('bi-menu-button')
			->url(fn(Menu $record): string => static::getUrl('reorder', ['record' => $record]));

		$actions[] = EditAction::make()
			->label('')
			->tableIcon(fn($record) => $record->isLocked() ? 'bi-lock' : 'bi-pencil-square')
			->disabled(fn($record) => $record->isLocked());

		$actions[] = DeleteAction::make()
			->label('')
			->tableIcon(fn($record) => $record->isLocked() ? 'bi-lock' : 'bi-trash3')
			->disabled(fn($record) => $record->isLocked());

		return $actions;
	}

}
