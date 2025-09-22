<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum FormFieldType: string implements HasLabel
{
	case STRING = 'string';
	case EMAIL = 'email';
	case TEXT = 'text';
	case NUMBER = 'number';

	case TEXTAREA = 'textarea';

	case SELECT = 'select';
	case MULTI_SELECT = 'multiselect';

	case TOGGLE = 'toggle';
	case CHECKBOX = 'checkbox';
	case RADIO = 'radio';

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

			self::TOGGLE => 'Toggle',
			self::CHECKBOX => 'Checkbox',
			self::RADIO => 'Radio',

			self::DATE => 'Date',
			self::TIME => 'Time',
			self::DATE_TIME => 'Date Time',
		};
	}

	public function getDatabaseColumnType(): string
	{
		return match ($this) {
			FormFieldType::STRING,
			FormFieldType::EMAIL => 'varchar',
			FormFieldType::TEXT,
			FormFieldType::TEXTAREA,
			FormFieldType::SELECT => 'text',
			FormFieldType::NUMBER,
			FormFieldType::RADIO => 'int',
			FormFieldType::CHECKBOX,
			FormFieldType::TOGGLE => 'tinyint',
			FormFieldType::MULTI_SELECT => 'json',
			FormFieldType::DATE => 'date',
			FormFieldType::TIME => 'time',
			FormFieldType::DATE_TIME => 'timestamp',
		};
	}

	public function hasOptions(): string
	{
		return match ($this) {

			FormFieldType::SELECT,
			FormFieldType::MULTI_SELECT,
			FormFieldType::RADIO => true,
			FormFieldType::STRING,
			FormFieldType::EMAIL,
			FormFieldType::TEXT,
			FormFieldType::NUMBER,
			FormFieldType::TEXTAREA,
			FormFieldType::TOGGLE,
			FormFieldType::CHECKBOX,
			FormFieldType::DATE,
			FormFieldType::TIME,
			FormFieldType::DATE_TIME => false,
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
