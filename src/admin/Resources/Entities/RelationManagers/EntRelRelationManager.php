<?php

namespace Lara\Admin\Resources\Entities\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;
use Lara\Admin\Resources\Entities\RelationManagers\Schemas\EntityRelationForm;
use Lara\Admin\Resources\Entities\RelationManagers\Tables\EntityRelationsTable;

class EntRelRelationManager extends RelationManager
{
    protected static string $relationship = 'relations';

	public function form(Schema $schema): Schema
	{
		return EntityRelationForm::configure($schema);
	}

	public function table(Table $table): Table
	{
		return EntityRelationsTable::configure($table);
	}

	public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
	{
		return $ownerRecord->cgroup == 'entity';
	}


}
