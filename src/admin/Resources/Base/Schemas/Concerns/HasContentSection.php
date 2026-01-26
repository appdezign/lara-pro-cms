<?php

namespace Lara\Admin\Resources\Base\Schemas\Concerns;

use Awcodes\Mason\Bricks\Section;
use Awcodes\Mason\Mason;
use Cache;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\Storage;
use Lara\Admin\Components\GeoLocationField;
use Lara\Admin\Enums\EntityHook;
use Lara\Common\Models\Entity;
use Lara\Common\Models\Tag;

trait HasContentSection
{

	private static function getContentSection(): array
	{

		static::setContentLanguage();

		$rows = array();

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::BEFORE_TITLE->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		// Title
		$rows[] = TextInput::make('title')
			->label(_q(static::getModule() . '::' . static::getSlug() . '.column.title'))
			->maxLength(255)
			->extraAttributes(['class' => 'js-title-input'])
			->required();

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::AFTER_TITLE->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		// Slug
		$rows[] = TextInput::make('slug')
			->label(_q('lara-admin::default.column.slug'))
			->maxLength(255)
			->hintIcon(fn(Get $get): ?string => $get('slug_lock') ? 'bi-lock-fill' : null)
			->disabled()
			->visible(fn(string $operation) => $operation == 'edit');
		$rows[] = Toggle::make('slug_edit')
			->label(_q('lara-admin::default.column.slug_edit'))
			->live()
			->visible(fn(string $operation) => $operation == 'edit');
		$rows[] = Fieldset::make(_q('lara-admin::default.group.slug_edit'))
			->schema([
				TextInput::make('slug')
					->label(_q('lara-admin::default.column.slug'))
					->maxLength(255)
					->disabled(fn(Get $get): bool => $get('slug_lock')),
				Toggle::make('slug_lock')
					->label(_q('lara-admin::default.column.slug_lock'))
					->live(),
			])
			->visible(fn(Get $get): bool => $get('slug_edit'));

		// Relations
		foreach (static::getEntity()->relations as $relation) {
			if ($relation->type == 'belongsTo') {
				$relatedEntityClass = $relation->relatedEntity->model_class;
				$rows[] = Select::make($relation->foreign_key)
					->label(_q(static::getModule() . '::' . static::getSlug() . '.column.' . $relation->foreign_key))
					->options($relatedEntityClass::langIs(static::$clanguage)->pluck('title', 'id')->toArray())
					->required();
			}
		}

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::AFTER_SLUG->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		// Lead
		if (static::resourceHasLead()) {
			$rows = static::getRichEditorSection($rows, 'lead', static::leadHasRichEditor(), true);
		}

		// Body
		if (static::resourceHasBody()) {
			$rows = static::getRichEditorSection($rows, 'body', static::bodyHasRichEditor(), true);
		}

		$maxExtraFields = static::maxBodyFields();

		if ($maxExtraFields > 0) {
			for ($i = 1; $i <= $maxExtraFields; $i++) {
				$fieldNumber = $i + 1;
				$extraFieldname = 'body' . $fieldNumber;
				$rows = static::getRichEditorSection($rows, $extraFieldname, static::bodyHasRichEditor(), true, $fieldNumber);
			}
		}

		// Template (Pages only)
		if (static::getSlug() == 'pages') {
			$rows[] = Select::make('template')
				->label(_q('lara-admin::default.column.template'))
				->options(static::getEntity()->views()->IsSingle()->pluck('template', 'template')->toArray())
				->required();
		}

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::AFTER_LAST->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		$rows[] = Hidden::make('language')->default(static::$clanguage);

		return $rows;

	}

	private static function getRichEditorSection(array $rows, string $fieldname, bool $hasRichEditor = false, bool $toggle = false, ?int $extraFieldNumber = null): array
	{
		if ($hasRichEditor) {

			$rows[] = RichEditor::make($fieldname)
				->label(_q('lara-admin::default.column.' . $fieldname))
				->live()
				->customBlocks(config('lara-admin.rich_editor.custom_blocks'))
				->extraInputAttributes(['style' => 'min-height: 8rem;'])
				->visible(fn(Get $get): bool => is_null($extraFieldNumber) || static::templateHasExtraField($get, $extraFieldNumber));
		} else {

			$rows[] = Textarea::make($fieldname)
				->label(_q('lara-admin::default.column.' . $fieldname))
				->extraInputAttributes(['style' => 'min-height: 16rem;'])
				->visible(fn(Get $get): bool => is_null($extraFieldNumber) || static::templateHasExtraField($get, $extraFieldNumber));

		}

		return $rows;
	}

	private static function templateHasExtraField($get, $fieldNumber): bool
	{
		$template = $get('template');
		if ($template) {
			$view = static::getEntity()->views()->where('template', $template)->first();
			$templateExtraFields = $view->template_extra_fields;
			if ($templateExtraFields + 1 >= $fieldNumber) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	private static function getCustomFieldsByHook($hook)
	{
		$cacheKey = 'lara_entity_custom_fields_' . static::getSlug() . '_' . $hook;

		return Cache::rememberForever($cacheKey, function () use ($hook) {
			return static::getEntity()->customfields()->where('field_hook', $hook)->orderBy('sort_order')->get();
		});
	}

	private static function getFilamentComponent($field): array
	{

		$rows = array();

		$state = $field->rule_state;

		$label = _q(static::getModule() . '::' . static::getSlug() . '.column.' . $field->field_name);

		switch ($field->field_type) {
			case 'string':
			case 'text':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'email':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->email()
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'number':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->numeric()
					->default(0)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'textarea':
				$rows[] = Textarea::make($field->field_name)
					->label($label)
					->extraInputAttributes(['style' => 'min-height: 8rem;'])
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'select':
				$rows[] = Select::make($field->field_name)
					->label($label)
					->live()
					->options(fn($record) => static::getSelectFieldOptions($record, $field))
					->searchable(false)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'multiselect':
				$rows[] = Select::make($field->field_name)
					->label($label)
					->multiple()
					->options(array_combine($field->field_options, $field->field_options))
					->searchable(false)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'tagsinput':
				$rows[] = Tagsinput::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'toggle':
				$rows[] = Hidden::make($field->field_name);
				$rows[] = Toggle::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'togglebuttons':
				$rows[] = ToggleButtons::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'multitogglebuttons':
				$rows[] = ToggleButtons::make($field->field_name)
					->label($label)
					->multiple()
					->options(array_combine($field->field_options, $field->field_options))
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'checkbox':
				$rows[] = Hidden::make($field->field_name);
				$rows[] = Checkbox::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'checkboxlist':
				$rows[] = CheckboxList::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'radio':
				$rows[] = Radio::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'colorpicker':
				$rows[] = ColorPicker::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'decimal_10_1':
			case 'decimal_14_2':
			case 'decimal_16_4':
			case 'latitude_10_8':
			case 'longitude_11_8':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->numeric()
					->default(0)
					->step('any')
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'date':
				$rows[] = DatePicker::make($field->field_name)
					->label($label)
					->default(now())
					->displayFormat('Y-m-d')
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'time':
				$rows[] = TimePicker::make($field->field_name)
					->label($label)
					->seconds(false)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'datetime':
				$rows[] = DateTimePicker::make($field->field_name)
					->label($label)
					->default(now())
					->displayFormat('Y-m-d H:i')->disabled($state == 'disabled')
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'mason':
				$rows[] = Mason::make($field->field_name)
					->label($label)
					->bricks([
						Section::class,
					])
					->placeholder(_q('lara-admin::default.mason.drag_and_drop_bricks'))
					->doubleClickToEdit()
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));;
				break;
			case 'geolocation':
				$rows[] = Fieldset::make(_q('lara-admin::default.group.geolocation', true))
					->schema([
						TextInput::make('geo_address')
							->label(_q('lara-admin::default.column.geo_address'))
							->columnSpanFull(),

						TextInput::make('geo_pcode')
							->label(_q('lara-admin::default.column.geo_pcode'))
							->columnSpanFull(),

						TextInput::make('geo_city')
							->label(_q('lara-admin::default.column.geo_city'))
							->columnSpanFull(),

						TextInput::make('geo_country')
							->label(_q('lara-admin::default.column.geo_country'))
							->columnSpanFull(),

						GeoLocationField::make('geo_location')
							->label(_q('lara-admin::default.column.geo_location'))
							->live()
							->native(false)
							->options([
								'auto'   => 'auto',
								'manual' => 'manual',
								'hidden' => 'hidden',
							])
							->columnSpanFull(),

						TextInput::make('geo_latitude')
							->label(_q('lara-admin::default.column.geo_latitude'))
							->visible(fn(Get $get) => $get('geo_location') != 'hidden')
							->disabled(fn(Get $get) => $get('geo_location') == 'auto')
							->extraAttributes(['class' => 'js-geo-latitude'])
							->columnSpanFull(),

						TextInput::make('geo_longitude')
							->label(_q('lara-admin::default.column.geo_longitude'))
							->visible(fn(Get $get) => $get('geo_location') != 'hidden')
							->disabled(fn(Get $get) => $get('geo_location') == 'auto')
							->extraAttributes(['class' => 'js-geo-longitude'])
							->columnSpanFull(),
					]);

		}

		// Add hidden fields if necessary
		switch ($field->field_type) {
			case 'decimal_10_1':
			case 'decimal_14_2':
			case 'decimal_16_4':
			case 'latitude_10_8':
			case 'longitude_11_8':
				$rows[] = Hidden::make($field->field_name)
					->default(0)
					->visible($state == 'hidden');
				break;
			default:
				$rows[] = Hidden::make($field->field_name)
					->visible($state == 'hidden');
		}

		return $rows;

	}

	private static function getSelectFieldOptions($record, $field): array
	{
		if (!empty($field->field_options)) {
			if ($field->field_options[0] == 'get_entity_resources') {
				return Entity::where('cgroup', 'entity')->pluck('resource_slug', 'resource_slug')->toArray();
			}
			if ($field->field_options[0] == 'get_entity_terms') {
				if ($record && $record->resource_slug) {
					return Tag::where('language', $record->language)->where('resource_slug', $record->resource_slug)->pluck('slug', 'slug')->toArray();
				} else {
					return [];
				}

			}
			if ($field->field_options[0] == 'get_widget_templates') {
				if ($record) {
					return static::getBladeTemplates($record);
				} else {
					return [];
				}
			}

		}

		return array_combine($field->field_options, $field->field_options);
	}

	private static function getFieldState($get, $field): bool
	{

		if ($field->rule_state == 'enabled') {
			return true;
		} elseif ($field->rule_state == 'disabled') {
			return true;
		} elseif ($field->rule_state == 'hidden') {
			return false;
		} elseif ($field->rule_state == 'enabledif') {
			if ($field->rule_operator == 'isequal') {
				return $get($field->rule_field) == $field->rule_value;
			} elseif ($field->rule_operator == 'isnotequal') {
				return $get($field->rule_field) != $field->rule_value;
			} else {
				return false;
			}
		}
	}

	private static function getBladeTemplates($record, bool $default = false): array
	{

		if ($default || empty($record)) {

			$fileArray = ['default' => 'default'];

		} else {

			$themepath = config('theme.active');
			$parentpath = config('theme.parent');

			$widgetpath = 'laracms/themes/' . $themepath . '/views/_widgets/lara/';
			$fallbackpath = 'laracms/themes/' . $parentpath . '/views/_widgets/lara/';

			$fileArray = array();

			if ($record->type == 'module') {

				$bladepath = $widgetpath . 'entity';

				$files = Storage::disk('lara')->files($bladepath);

				if(empty($files)) {
					$bladepath = $fallbackpath . 'entity';
					$files = Storage::disk('lara')->files($bladepath);
				}

				foreach ($files as $file) {
					$filename = basename($file);
					$pos = strrpos($filename, '.blade.php');
					if ($pos !== false) {
						$tname = substr($filename, 0, $pos);
						if (str_ends_with($tname, $record->resource_slug)) {
							// $val = substr($tname, 0, strlen($tname) - strlen($record->resource_slug) - 1);
							$fileArray[$tname] = $tname;
						}
					}
				}

			} else {

				$bladepath = $widgetpath . 'text';
				$files = Storage::disk('lara')->files($bladepath);

				if(empty($files)) {
					$bladepath = $fallbackpath . 'text';
					$files = Storage::disk('lara')->files($bladepath);
				}

				foreach ($files as $file) {
					$filename = basename($file);
					$pos = strrpos($filename, '.blade.php');
					if ($pos !== false) {
						$tname = substr($filename, 0, $pos);
						if (str_starts_with($tname, $record->type)) {
							$val = substr($tname, strlen($record->type) + 1);
							$fileArray[$val] = $val;
						}
					}
				}
			}
		}

		return $fileArray;

	}

}