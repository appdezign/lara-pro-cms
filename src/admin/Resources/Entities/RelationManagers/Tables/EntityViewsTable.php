<?php

namespace Lara\Admin\Resources\Entities\RelationManagers\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Filament\Resources\RelationManagers\RelationManager;


class EntityViewsTable
{
	protected static ?string $slug = 'entityviews';
	protected static ?string $module = 'lara-admin';

	public static function configure(Table $table): Table
	{
		return $table
			->columns([
				IconColumn::make('publish')
					->label(_q('lara-admin::default.column.publish'))
					->width('5%')
					->boolean()
					->size('md'),
				TextColumn::make('title')
					->label(_q(static::module() . '::' . static::slug() . '.column.title')),
				TextColumn::make('entity.title')
					->label(_q(static::module() . '::' . static::slug() . '.column.entity')),
				TextColumn::make('method')
					->label(_q(static::module() . '::' . static::slug() . '.column.method')),
				IconColumn::make('is_single')
					->label(_q(static::module() . '::' . static::slug() . '.column.is_single'))
					->boolean()
					->trueIcon('bi-check2-circle')
					->trueColor('gray')
					->state(fn($record) => ($record->is_single == 1) ? 1 : null)
					->size('sm'),
				TextColumn::make('list_type')
					->label(_q(static::module() . '::' . static::slug() . '.column.list_type')),
				TextColumn::make('showtags')
					->label(_q(static::module() . '::' . static::slug() . '.column.showtags')),
				TextColumn::make('paginate')
					->label(_q(static::module() . '::' . static::slug() . '.column.paginate')),
				IconColumn::make('prevnext')
					->label(_q(static::module() . '::' . static::slug() . '.column.prevnext'))
					->boolean()
					->trueIcon('bi-check2-circle')
					->trueColor('gray')
					->state(fn($record) => ($record->prevnext == 1) ? 1 : null)
					->size('sm'),
				TextColumn::make('template')
					->label(_q(static::module() . '::' . static::slug() . '.column.template'))
					->visible(function (RelationManager $livewire) {
						return $livewire->getOwnerRecord()->resource_slug == 'pages';
					}),

			])
			->headerActions([
				CreateAction::make()
					->icon('bi-plus-lg')
					->iconButton(),
			])
			->actions([
				EditAction::make()
					->label('')
					->mutateFormDataUsing(function (array $data): array {
						if ($data['is_single'] == 1) {
							$data['list_type'] = '_single';
						}
						return $data;
					}),
			])
			->bulkActions([]);
	}

	private static function slug(): string
	{
		return static::$slug;
	}

	private static function module(): string
	{
		return static::$module;
	}

}
