<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum FormFieldType: string implements HasLabel
{
	case String = 'string';
	case Email = 'email';
	case Text = 'text';
	case Number = 'number';

	case Textarea = 'textarea';

	case Select = 'select';
	case MultiSelect = 'multiselect';

	case Toggle = 'toggle';
	case Checkbox = 'checkbox';
	case Radio = 'radio';

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

			self::Select => 'Select',
			self::MultiSelect => 'Multi Select',

			self::Toggle => 'Toggle',
			self::Checkbox => 'Checkbox',
			self::Radio => 'Radio',

			self::Date => 'Date',
			self::Time => 'Time',
			self::DateTime => 'Date Time',
		};
	}

	public function getDatabaseColumnType(): string
	{
		return match ($this) {
			FormFieldType::String,
			FormFieldType::Email => 'varchar',
			FormFieldType::Text,
			FormFieldType::Textarea,
			FormFieldType::Select => 'text',
			FormFieldType::Number,
			FormFieldType::Radio => 'int',
			FormFieldType::Checkbox,
			FormFieldType::Toggle => 'tinyint',
			FormFieldType::MultiSelect => 'json',
			FormFieldType::Date => 'date',
			FormFieldType::Time => 'time',
			FormFieldType::DateTime => 'timestamp',
		};
	}

	public function hasOptions(): string
	{
		return match ($this) {

			FormFieldType::Select,
			FormFieldType::MultiSelect,
			FormFieldType::Radio => true,
			FormFieldType::String,
			FormFieldType::Email,
			FormFieldType::Text,
			FormFieldType::Number,
			FormFieldType::Textarea,
			FormFieldType::Toggle,
			FormFieldType::Checkbox,
			FormFieldType::Date,
			FormFieldType::Time,
			FormFieldType::DateTime => false,
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
