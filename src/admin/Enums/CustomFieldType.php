<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum CustomFieldType: string implements HasLabel
{
	case STRING = 'string';
	case EMAIL = 'email';
	case TEXT = 'text';
	case NUMBER = 'number';

	case TEXTAREA = 'textarea';

	case SELECT = 'select';
	case MULTI_SELECT = 'multiselect';

	case TAGS_INPUT = 'tagsinput';
	case TOGGLE = 'toggle';
	case TOGGLE_BUTTONS = 'togglebuttons';
	case CHECKBOX = 'checkbox';
	case CHECKBOX_LIST = 'checkboxlist';
	case RADIO = 'radio';

	case COLOR_PICKER = 'colorpicker';

	case DECIMAL101 = 'decimal_10_1';
	case DECIMAL142 = 'decimal_14_2';
	case DECIMAL164 = 'decimal_16_4';
	case LATITUDE = 'latitude_10_8';
	case LONGITUDE = 'longitude_11_8';

	case GEOLOCATION = 'geolocation';

	case DATE = 'date';
	case TIME = 'time';
	case DATE_TIME = 'datetime';

	public function getLabel(): ?string
	{
		return match ($this) {

			self::STRING => 'String',
			self::EMAIL => 'Email',
			self::TEXT => 'Text',
			self::NUMBER => 'Number',

			self::TEXTAREA => 'Textarea',

			self::SELECT => 'Select',
			self::MULTI_SELECT => 'Multi Select',

			self::TAGS_INPUT => 'Tags Input',
			self::TOGGLE => 'Toggle',
			self::TOGGLE_BUTTONS => 'Toggle Buttons',
			self::CHECKBOX => 'Checkbox',
			self::CHECKBOX_LIST => 'Checkbox List',
			self::RADIO => 'Radio',

			self::COLOR_PICKER => 'Color Picker',

			self::DECIMAL101 => 'Decimal (10,1)',
			self::DECIMAL142 => 'Decimal (14,2)',
			self::DECIMAL164 => 'Decimal (16,4)',
			self::LATITUDE => 'Latitude (10,8)',
			self::LONGITUDE => 'Longitude (11,8)',

			self::GEOLOCATION => 'Geolocation',

			self::DATE => 'Date',
			self::TIME => 'Time',
			self::DATE_TIME => 'Date Time',
		};
	}

	public function getDatabaseColumnType(): string
	{
		return match ($this) {
			CustomFieldType::STRING,
			CustomFieldType::EMAIL,
			CustomFieldType::GEOLOCATION,
			CustomFieldType::COLOR_PICKER => 'varchar',
			CustomFieldType::TEXT,
			CustomFieldType::TEXTAREA,
			CustomFieldType::SELECT => 'text',
			CustomFieldType::NUMBER,
			CustomFieldType::RADIO => 'int',
			CustomFieldType::CHECKBOX,
			CustomFieldType::TOGGLE => 'tinyint',
			CustomFieldType::CHECKBOX_LIST,
			CustomFieldType::TOGGLE_BUTTONS,
			CustomFieldType::TAGS_INPUT,
			CustomFieldType::MULTI_SELECT => 'json',
			CustomFieldType::LATITUDE,
			CustomFieldType::LONGITUDE,
			CustomFieldType::DECIMAL101,
			CustomFieldType::DECIMAL142,
			CustomFieldType::DECIMAL164 => 'decimal',
			CustomFieldType::DATE => 'date',
			CustomFieldType::TIME => 'time',
			CustomFieldType::DATE_TIME => 'timestamp',
		};
	}

	public function hasOptions(): string
	{
		return match ($this) {

			CustomFieldType::SELECT,
			CustomFieldType::MULTI_SELECT,
			CustomFieldType::TOGGLE_BUTTONS,
			CustomFieldType::CHECKBOX_LIST,
			CustomFieldType::RADIO => true,
			CustomFieldType::STRING,
			CustomFieldType::EMAIL,
			CustomFieldType::TEXT,
			CustomFieldType::NUMBER,
			CustomFieldType::TEXTAREA,
			CustomFieldType::TAGS_INPUT,
			CustomFieldType::TOGGLE,
			CustomFieldType::CHECKBOX,
			CustomFieldType::COLOR_PICKER,
			CustomFieldType::DECIMAL101,
			CustomFieldType::DECIMAL142,
			CustomFieldType::DECIMAL164,
			CustomFieldType::LATITUDE,
			CustomFieldType::LONGITUDE,
			CustomFieldType::GEOLOCATION,
			CustomFieldType::DATE,
			CustomFieldType::TIME,
			CustomFieldType::DATE_TIME => false,
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
