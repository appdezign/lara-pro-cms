<?php


namespace Lara\Admin\Resources\Forms\RelationManagers\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormViewsTable
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

		    ])
		    ->headerActions([
			    CreateAction::make()
				    ->icon('heroicon-s-plus')
				    ->iconButton(),
		    ])
		    ->actions([
			    EditAction::make()->label(''),
		    ])
		    ->bulkActions([]);
    }

	private static function slug(): string {
		return static::$slug;
	}

	private static function module(): string {
		return static::$module;
	}
}
