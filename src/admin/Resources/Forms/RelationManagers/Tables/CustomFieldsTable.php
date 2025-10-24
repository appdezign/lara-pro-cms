<?php


namespace Lara\Admin\Resources\Forms\RelationManagers\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Lara\Admin\Traits\HasCache;
use Lara\Admin\Traits\HasLaraBuilder;
use Lara\Common\Models\EntityCustomField;

class CustomFieldsTable
{

	use HasLaraBuilder;
	use HasCache;

	protected static ?string $slug = 'customfields';
	protected static ?string $module = 'lara-admin';

	public static function configure(Table $table): Table
	{

		return $table
			->columns([
				TextColumn::make('title')
					->label(_q(static::module() . '::' . static::slug() . '.column.title')),
				TextColumn::make('field_name')
					->label(_q(static::module() . '::' . static::slug() . '.column.field_name')),
				TextColumn::make('field_type')
					->label(_q(static::module() . '::' . static::slug() . '.column.field_type')),
				TextColumn::make('field_hook')
					->label(_q(static::module() . '::' . static::slug() . '.column.field_hook')),
				IconColumn::make('is_required')
					->label(_q(static::module() . '::' . static::slug() . '.column.is_required'))
					->boolean()
					->trueIcon('bi-check2-circle')
					->trueColor('gray')
					->state(fn($record) => ($record->is_required == 1) ? 1 : null)
					->size('sm'),

				IconColumn::make('show_in_list')
					->label(_q(static::module() . '::' . static::slug() . '.column.show_in_list'))
					->boolean()
					->trueIcon('bi-check2-circle')
					->trueColor('gray')
					->state(fn($record) => ($record->show_in_list == 1) ? 1 : null)
					->size('sm'),
				IconColumn::make('conditional')
					->label(_q(static::module() . '::' . static::slug() . '.column.conditional'))
					->boolean()
					->trueIcon('bi-sliders')
					->trueColor('gray')
					->state(fn($record) => ($record->conditional == 1) ? 1 : null)
					->size('md'),
				TextColumn::make('sort_order')
					->label(_q(static::module() . '::' . static::slug() . '.column.sort_order')),
			])
			->headerActions([
				CreateAction::make()
					->icon('bi-plus-lg')
					->iconButton()
					->after(function (RelationManager $livewire, EntityCustomField $customField) {
						static::checkRuleState($customField);
						static::checkCustomDatabaseColumns($livewire->getOwnerRecord());
						static::clearCacheTypes();
					}),
			])
			->actions([
				EditAction::make()
					->label('')
					->after(function (RelationManager $livewire, EntityCustomField $customField) {
						static::checkRuleState($customField);
						static::checkCustomDatabaseColumns($livewire->getOwnerRecord());
						static::clearCacheTypes();
					}),
				DeleteAction::make()
					->label('')
					->after(function (EntityCustomField $customField) {
						static::dropCustomColumn($customField);
						static::clearCacheTypes();
					}),
			])
			->bulkActions([])
			->defaultSort('sort_order', 'asc')
			->paginated(false);
	}

	private static function checkRuleState(EntityCustomField $customField): void
	{

		if (empty($customField->rule_state)) {
			$customField->rule_state = 'enabled';
			$customField->save();
		}

		if ($customField->conditional == 0) {
			$customField->rule_field = null;
			$customField->rule_operator = null;
			$customField->rule_value = null;
			$customField->save();
		}

	}

	private static function slug(): string {
		return static::$slug;
	}

	private static function module(): string {
		return static::$module;
	}
}
