<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum FormHook: string implements HasLabel
{
	case Default = 'default';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::Default => 'default',
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
