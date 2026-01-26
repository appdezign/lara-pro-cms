<?php

namespace Lara\Admin\Resources\Base\Schemas\Concerns;

use Filament\Forms\Components\Select;
use Lara\Common\Models\User;

trait HasAuthorSection
{
	private static function getAuthorSection(): array
	{
		$rows = array();

		$rows[] = Select::make('user_id')
			->label(_q('lara-admin::default.column.user_id'))
			->options(User::where('id', auth()->id())->pluck('name', 'id'))
			->native(false)
			->default(auth()->id())
			->selectablePlaceholder(false)
			->visible(fn(string $operation) => $operation == 'create');

		$rows[] = Select::make('user_id')
			->label(_q('lara-admin::default.column.user_id'))
			->relationship('user', 'name')
			->preload()
			->selectablePlaceholder(false)
			->visible(fn(string $operation) => $operation == 'edit');

		return $rows;

	}
}