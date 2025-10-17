<?php


namespace Lara\Admin\Resources\Entities\RelationManagers\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Lara\Admin\Resources\Entities\RelationManagers\Concerns\HasRelations;
use Lara\Common\Models\Entity;

class EntityRelationsTable
{

	use HasRelations;

	protected static ?string $slug = 'entityrelations';
	protected static ?string $module = 'lara-admin';

	public static function configure(Table $table): Table
    {
	    return $table
		    ->columns([
			    TextColumn::make('entity_id')
				    ->label(_q(static::module() . '::' . static::slug() . '.column.entity_id'))
				    ->getStateUsing(function ($record) {
					    return $record->entity->title;
				    }),
			    TextColumn::make('type')
				    ->label(_q(static::module() . '::' . static::slug() . '.column.type')),
			    TextColumn::make('related_entity_id')
				    ->label(_q(static::module() . '::' . static::slug() . '.column.related_entity_id'))
				    ->getStateUsing(function ($record) {
					    $relatedEntity = Entity::find($record->related_entity_id);
					    if ($relatedEntity) {
						    return $relatedEntity->title;
					    } else {
						    return null;
					    }
				    }),
			    TextColumn::make('foreign_key')
				    ->label(_q(static::module() . '::' . static::slug() . '.column.foreign_key')),
			    IconColumn::make('is_filter')
				    ->label(_q(static::module() . '::' . static::slug() . '.column.is_filter'))
				    ->boolean()
				    ->trueIcon('bi-check2-circle')
				    ->size('sm'),

		    ])
		    ->headerActions([
			    CreateAction::make()
				    ->icon('bi-plus-lg')
				    ->iconButton()
				    ->after(function ($record) {
					    static::checkRelations($record->entity);
				    }),
		    ])
		    ->actions([
			    EditAction::make()
				    ->label('')
				    ->after(function ($record) {
					    static::checkRelations($record->entity);
				    }),
			    DeleteAction::make()
				    ->label('')
				    ->after(function ($record) {
					    static::checkRelations($record->entity);
				    })
				    ->disabled(fn($record) => $record->type == 'belongsTo'),
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
