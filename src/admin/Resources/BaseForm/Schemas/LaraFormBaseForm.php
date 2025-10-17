<?php

namespace Lara\Admin\Resources\BaseForm\Schemas;

use Cache;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Lara\Admin\Components\YouTubeField;
use Lara\Admin\Enums\FormHook;
use Lara\Admin\Enums\ImageFields;
use Lara\Admin\Enums\ImageHooks;
use Lara\Admin\Enums\LayoutSections;
use Lara\Admin\Resources\Base\Schemas\Radio;
use Lara\Common\Models\Entity;
use Lara\Common\Models\MenuItem;
use Lara\Common\Models\ObjectLayout;
use Lara\Common\Models\Page;
use Lara\Common\Models\Tag;
use Lara\Common\Models\User;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

use Schmeits\FilamentCharacterCounter\Forms\Components\Textarea as TextAreaWithCounter;
// use Awcodes\Curator\Components\Forms\CuratorPicker;

trait LaraFormBaseForm
{

	private static function getLaraFormTabs(): array
	{

		$tabs = array();

		$tabs[] = Tab::make(_q('lara-admin::default.tabs.content', true))
			->schema(static::getContentSections());

		return $tabs;

	}

	private static function getContentSections(): array
	{
		$sections = array();

		$sections[] = Section::make(_q('lara-admin::default.section.content', true))
			->collapsible()
			->schema(static::getContentSection());

		return $sections;
	}


	private static function getContentSection(): array
	{

		static::setContentLanguage();

		$rows = array();

		// Custom Fields
		foreach (static::getCustomFieldsByHook(FormHook::DEFAULT->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		return $rows;

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
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'email':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->email()
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'number':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->numeric()
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
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'multiselect':
				$rows[] = Select::make($field->field_name)
					->label($label)
					->multiple()
					->options(array_combine($field->field_options, $field->field_options))
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'tagsinput':
				$rows[] = Tagsinput::make($field->field_name)
					->label($label)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'toggle':
				$rows[] = Hidden::make($field->field_name);
				$rows[] = Toggle::make($field->field_name)
					->label($label)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'togglebuttons':
				$rows[] = ToggleButtons::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'checkbox':
				$rows[] = Hidden::make($field->field_name);
				$rows[] = Checkbox::make($field->field_name)
					->label($label)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'checkboxlist':
				$rows[] = CheckboxList::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'radio':
				$rows[] = Radio::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'colorpicker':
				$rows[] = ColorPicker::make($field->field_name)
					->label($label)
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
					->default(0)
					->numeric()
					->step('any')
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'date':
				$rows[] = DatePicker::make($field->field_name)
					->label($label)
					->default(now())
					->displayFormat('Y-m-d')
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'time':
				$rows[] = TimePicker::make($field->field_name)
					->label($label)
					->seconds(false)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'datetime':
				$rows[] = DateTimePicker::make($field->field_name)
					->label($label)
					->default(now())
					->displayFormat('Y-m-d H:i')->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'geolocation':
				$rows[] = Select::make($field->field_name)
					->label($label)
					->options([
						'auto'   => 'auto',
						'manual' => 'manual',
						'hidden' => 'hidden',
					]);
		}

		// Add hidhen fields if necessary
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


}
