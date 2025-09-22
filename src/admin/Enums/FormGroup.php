<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum FormGroup: string implements HasLabel
{
	case Form = 'form';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::Form => 'Form',
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
