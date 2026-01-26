<?php

namespace Lara\Admin\Resources\Entities\RelationManagers\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Lara\Admin\Enums\CustomFieldType;
use Lara\Admin\Enums\EntityHook;
use Lara\Common\Models\EntityCustomField;

use Closure;

class CustomFieldForm
{
	protected static ?string $slug = 'customfields';
	protected static ?string $module = 'lara-admin';

	public static function configure(Schema $schema): Schema
	{

		return $schema
			->components([
				Section::make('Content')
					->columnSpanFull()
					->collapsible()
					->schema([
						TextInput::make('title')
							->label(_q(static::module() . '::' . static::slug() . '.column.title'))
							->required(),
						TextInput::make('field_name')
							->label(_q(static::module() . '::' . static::slug() . '.column.field_name'))
							->rules([
								fn(RelationManager $livewire, $operation): Closure => function (string $attribute, $value, Closure $fail) use ($livewire, $operation) {
									if ($operation == 'create') {
										$entity = $livewire->getOwnerRecord();
										$check = $entity->customfields()->where('field_name', $value)->first();
										if ($check) {
											$fail('The field_name already exists.');
										}
									}
								},
							])
							->disabled(fn(string $operation): bool => $operation == 'edit')
							->visible(function (string $operation, Get $get): bool {
								return $operation == 'create' || ($operation == 'edit' && !$get('field_name_edit'));
							}),
						TextInput::make('field_name_temp')
							->label(_q(static::module() . '::' . static::slug() . '.column.field_name_temp'))
							->rules([
								fn(RelationManager $livewire, $operation): Closure => function (string $attribute, $value, Closure $fail) use ($livewire, $operation) {
									if ($operation == 'edit') {
										$entity = $livewire->getOwnerRecord();
										$check = $entity->customfields()->where('field_name', $value)->first();
										if ($check) {
											$fail('The field_name already exists.');
										}
									}
								},
							])
							->visible(fn(string $operation, Get $get): bool => $operation == 'edit' && $get('field_name_edit')),
						Toggle::make('field_name_edit')
							->label(_q(static::module() . '::' . static::slug() . '.column.field_name_edit'))
							->live()
							->afterStateUpdated(function ($state, Set $set, Get $get) {
								if ($state) {
									$set('field_name_temp', $get('field_name'));
								} else {
									$set('field_name_temp', null);
								}
							})->visible(fn(string $operation): bool => $operation == 'edit'),
						Select::make('field_type')
							->label(_q(static::module() . '::' . static::slug() . '.column.field_type'))
							->live()
							->options(CustomFieldType::toArray())
							->default('string')
							->afterStateUpdated(function (Set $set) {
								$set('field_options', null);
							})
							->required(),
						TagsInput::make('field_options')
							->label(_q(static::module() . '::' . static::slug() . '.column.field_options'))
							->placeholder('options')
							->visible(function (Get $get): bool {
								return in_array($get('field_type'), static::getFieldTypesWithOptions());
							}),
						Select::make('field_hook')
							->label(_q(static::module() . '::' . static::slug() . '.column.field_hook'))
							->options(EntityHook::class)
							->default('after-last')
							->required(),

						Toggle::make('show_in_list')
							->label(_q(static::module() . '::' . static::slug() . '.column.show_in_list')),

						Toggle::make('is_required')
							->label(_q(static::module() . '::' . static::slug() . '.column.is_required')),

						Toggle::make('is_filter')
							->label(_q(static::module() . '::' . static::slug() . '.column.is_filter')),

						TextInput::make('sort_order')
							->label(_q(static::module() . '::' . static::slug() . '.column.sort_order'))
							->numeric(),

						Toggle::make('conditional')
							->label(_q(static::module() . '::' . static::slug() . '.column.conditional'))
							->live()
							->afterStateUpdated(function (Set $set) {
								$set('rule_state', 'enabled');
							})
							->visible(fn(string $operation) => $operation == 'edit'),
						Hidden::make('rule_state')
							->default('enabled'),
						Fieldset::make('Status')
							->columns(3)
							->schema([
								Select::make('rule_state')
									->columnSpanFull()
									->hiddenLabel()
									->live()
									->options([
										'enabled'   => 'enabled',
										'enabledif' => 'enabledif',
										'hidden'    => 'hidden',
										'disabled'  => 'disabled',
									])
									->default('enabled')
									->selectablePlaceholder(false)
									->afterStateUpdated(function (Set $set, $state) {
										if ($state == 'enabled') {
											$set('rule_field', null);
											$set('rule_operator', null);
											$set('rule_value', null);
										}
									}),

								Hidden::make('rule_field')
									->default(null),
								Hidden::make('rule_operator')
									->default(null),
								Hidden::make('rule_value')
									->default(null),

								Select::make('rule_field')
									->hiddenLabel()
									->options(function ($record) {
										return EntityCustomField::where('entity_id', $record->entity_id)->pluck('field_name', 'field_name')->toArray();
									})
									->required(fn(Get $get): bool => $get('rule_state') == 'enabledif')
									->visible(fn(Get $get): bool => $get('rule_state') == 'enabledif'),

								Select::make('rule_operator')
									->hiddenLabel()
									->options([
										'isequal'    => 'is equal to',
										'isnotequal' => 'is not equal to',
									])
									->required(fn(Get $get): bool => $get('rule_state') == 'enabledif')
									->visible(fn(Get $get): bool => $get('rule_state') == 'enabledif'),

								TextInput::make('rule_value')
									->hiddenLabel()
									->required(fn(Get $get): bool => $get('rule_state') == 'enabledif')
									->visible(fn(Get $get): bool => $get('rule_state') == 'enabledif'),

							])
							->visible(fn(Get $get): bool => $get('conditional')),

					]),
			]);
	}

	private static function getFieldTypesWithOptions(): array
	{
		$fieldTypesWithOptions = array();

		foreach (CustomFieldType::cases() as $fieldType) {
			if ($fieldType->hasOptions()) {
				$fieldTypesWithOptions[] = $fieldType->value;
			}
		}

		return $fieldTypesWithOptions;
	}

	private static function slug(): string {
		return static::$slug;
	}

	private static function module(): string {
		return static::$module;
	}


}
