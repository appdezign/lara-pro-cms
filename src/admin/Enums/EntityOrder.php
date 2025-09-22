<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityOrder: string implements HasLabel
{
	case ASC = 'asc';
	case DESC = 'desc';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::ASC => 'asc',
			self::DESC => 'desc',
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
