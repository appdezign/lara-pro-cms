<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum CustomFieldType: string implements HasLabel
{
	case String = 'string';
	case Email = 'email';
	case Text = 'text';
	case Number = 'number';

	case Textarea = 'textarea';
	case RichEditor = 'richeditor';
	case RichEditorMin = 'richeditormin';

	case Select = 'select';
	case MultiSelect = 'multiselect';

	case TagsInput = 'tagsinput';
	case Toggle = 'toggle';
	case ToggleButtons = 'togglebuttons';
	case MultiToggleButtons = 'multitogglebuttons';
	case Checkbox = 'checkbox';
	case CheckboxList = 'checkboxlist';
	case Radio = 'radio';

	case ColorPicker = 'colorpicker';

	case Decimal101 = 'decimal_10_1';
	case Decimal142 = 'decimal_14_2';
	case Decimal164 = 'decimal_16_4';
	case Latitude = 'latitude_10_8';
	case Longitude = 'longitude_11_8';

	case Geolocation = 'geolocation';

	case Date = 'date';
	case Time = 'time';
	case DateTime = 'datetime';

	public function getLabel(): ?string
	{
		return match ($this) {

			self::String => 'String',
			self::Email => 'Email',
			self::Text => 'Text',
			self::Number => 'Number',

			self::Textarea => 'Textarea',
			self::RichEditor => 'Rich Editor',
			self::RichEditorMin => 'Rich Editor (minimal)',

			self::Select => 'Select',
			self::MultiSelect => 'Multi Select',

			self::TagsInput => 'Tags Input',
			self::Toggle => 'Toggle',
			self::ToggleButtons => 'Toggle Buttons',
			self::MultiToggleButtons => 'Multi Toggle Buttons',
			self::Checkbox => 'Checkbox',
			self::CheckboxList => 'Checkbox List',
			self::Radio => 'Radio',

			self::ColorPicker => 'Color Picker',

			self::Decimal101 => 'Decimal (10,1)',
			self::Decimal142 => 'Decimal (14,2)',
			self::Decimal164 => 'Decimal (16,4)',
			self::Latitude => 'Latitude (10,8)',
			self::Longitude => 'Longitude (11,8)',

			self::Geolocation => 'Geolocation',

			self::Date => 'Date',
			self::Time => 'Time',
			self::DateTime => 'Date Time',
		};
	}

	public function getDatabaseColumnType(): string
	{
		return match ($this) {
			CustomFieldType::String,
			CustomFieldType::Email,
			CustomFieldType::Geolocation,
			CustomFieldType::ColorPicker => 'varchar',
			CustomFieldType::Text,
			CustomFieldType::Textarea,
			CustomFieldType::RichEditor,
			CustomFieldType::RichEditorMin,
			CustomFieldType::ToggleButtons,
			CustomFieldType::Radio,
			CustomFieldType::Select => 'text',
			CustomFieldType::Number => 'int',
			CustomFieldType::Checkbox,
			CustomFieldType::Toggle => 'tinyint',
			CustomFieldType::CheckboxList,
			CustomFieldType::MultiToggleButtons,
			CustomFieldType::TagsInput,
			CustomFieldType::MultiSelect => 'json',
			CustomFieldType::Latitude,
			CustomFieldType::Longitude,
			CustomFieldType::Decimal101,
			CustomFieldType::Decimal142,
			CustomFieldType::Decimal164 => 'decimal',
			CustomFieldType::Date => 'date',
			CustomFieldType::Time => 'time',
			CustomFieldType::DateTime => 'timestamp',
		};
	}

	public function hasOptions(): string
	{
		return match ($this) {

			CustomFieldType::Select,
			CustomFieldType::MultiSelect,
			CustomFieldType::ToggleButtons,
			CustomFieldType::MultiToggleButtons,
			CustomFieldType::CheckboxList,
			CustomFieldType::Radio => true,
			CustomFieldType::String,
			CustomFieldType::Email,
			CustomFieldType::Text,
			CustomFieldType::Number,
			CustomFieldType::Textarea,
			CustomFieldType::RichEditor,
			CustomFieldType::RichEditorMin,
			CustomFieldType::TagsInput,
			CustomFieldType::Toggle,
			CustomFieldType::Checkbox,
			CustomFieldType::ColorPicker,
			CustomFieldType::Decimal101,
			CustomFieldType::Decimal142,
			CustomFieldType::Decimal164,
			CustomFieldType::Latitude,
			CustomFieldType::Longitude,
			CustomFieldType::Geolocation,
			CustomFieldType::Date,
			CustomFieldType::Time,
			CustomFieldType::DateTime => false,
		};
	}

	public static function toArray(): array
	{
		$array = [];
		foreach (self::cases() as $case) {
			$array[$case->value] = $case->value;
		}
		return $array;
	}


}
