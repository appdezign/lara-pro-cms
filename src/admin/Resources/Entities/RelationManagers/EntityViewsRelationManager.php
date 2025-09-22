<?php

namespace Lara\Admin\Resources\Entities\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;

use Lara\Admin\Resources\Entities\RelationManagers\Schemas\EntityViewForm;
use Lara\Admin\Resources\Entities\RelationManagers\Tables\EntityViewsTable;

class EntityViewsRelationManager extends RelationManager
{
    protected static string $relationship = 'views';

	public function form(Schema $schema): Schema
	{
		return EntityViewForm::configure($schema);
	}

	public function table(Table $table): Table
	{
		return EntityViewsTable::configure($table);
	}

	public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
	{
		return $ownerRecord->cgroup == 'entity' || $ownerRecord->cgroup == 'page';
	}

}
