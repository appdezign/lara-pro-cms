<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityOrder: string implements HasLabel
{
	case Asc = 'asc';
	case Desc = 'desc';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::Asc => 'asc',
			self::Desc => 'desc',
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
