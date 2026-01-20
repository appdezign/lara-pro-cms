<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
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
use Lara\Common\Models\Entity;
use Lara\Common\Models\Tag;


use Awcodes\Mason\Mason;
use Awcodes\Mason\Bricks\Section;

use Cache;

trait HasBaseForm {

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