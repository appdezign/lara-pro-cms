<?php

namespace Lara\Admin\Resources\Entities\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Lara\Admin\Resources\Entities\RelationManagers\Schemas\CustomFieldForm;
use Lara\Admin\Resources\Entities\RelationManagers\Tables\CustomFieldsTable;

class CustomFieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'customfields';

	public function form(Schema $schema): Schema
	{
		return CustomFieldForm::configure($schema, static::getRelationship());
	}

	public function table(Table $table): Table
	{
		return CustomFieldsTable::configure($table);
	}

}
