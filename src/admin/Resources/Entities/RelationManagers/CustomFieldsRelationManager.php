<?php

namespace Lara\Admin\Resources\Entities\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Lara\Admin\Resources\Entities\RelationManagers\Schemas\CustomFieldForm;
use Lara\Admin\Resources\Entities\RelationManagers\Tables\CustomFieldsTable;
use Livewire\Attributes\On;

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

    /**
     * A backup column was restored as a field.
     */
    #[On('lara-custom-fields-changed')]
    public function refreshCustomFields(): void
    {
        $this->resetTable();
    }
}
