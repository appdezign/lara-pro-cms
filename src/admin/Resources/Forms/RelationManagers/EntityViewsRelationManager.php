<?php

namespace Lara\Admin\Resources\Forms\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;

use Lara\Admin\Resources\Forms\RelationManagers\Schemas\FormViewForm;
use Lara\Admin\Resources\Forms\RelationManagers\Tables\FormViewsTable;

class EntityViewsRelationManager extends RelationManager
{
    protected static string $relationship = 'views';

	public function form(Schema $schema): Schema
	{
		return FormViewForm::configure($schema);
	}

	public function table(Table $table): Table
	{
		return FormViewsTable::configure($table);
	}
}
